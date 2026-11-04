<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController
{
    // Read all data (GET /api/transactions) - hanya admin
    public function index(): JsonResponse
    {
        // with() mengambil data relasi (user & book) sekaligus
        $transactions = Transaction::with(['user', 'book'])->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil mengambil seluruh data transaksi',
            'data'    => $transactions,
        ], 200);
    }

    // Create data (POST /api/transactions) - customer yang sudah login
    public function store(Request $request): JsonResponse
    {
        // 1. Validasi (order_number, customer_id, dan total_amount dibuat otomatis)
        $validated = $request->validate([
            'book_id'  => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // 2. Generate order number yang unik
        $orderNumber = 'ORD-' . strtoupper(uniqid());

        // 3. Ambil user yang sedang login (dari token JWT)
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        // Proses 4-8 dibungkus transaksi database + lock, agar stok tetap benar
        // walaupun ada dua pembelian di waktu bersamaan.
        $result = DB::transaction(function () use ($validated, $orderNumber, $user) {
            // 4. Cari data buku dari request
            $book = Book::lockForUpdate()->find($validated['book_id']);

            // 5. Cek stok buku
            if ($book->stock < $validated['quantity']) {
                return null;
            }

            // 6. Hitung total harga (price x quantity)
            $totalAmount = $book->price * $validated['quantity'];

            // 7. Kurangi stok buku
            $book->stock -= $validated['quantity'];
            $book->save();

            // 8. Simpan data transaksi
            return Transaction::create([
                'order_number' => $orderNumber,
                'customer_id'  => $user->id,
                'book_id'      => $book->id,
                'quantity'     => $validated['quantity'],
                'total_amount' => $totalAmount,
            ]);
        });

        if (!$result) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Stok buku tidak cukup',
            ], 400);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil menambahkan data transaksi',
            'data'    => $result->load(['user', 'book']),
        ], 201);
    }

    // Show data (GET /api/transactions/{id}) - customer yang sudah login
    public function show(string $id): JsonResponse
    {
        $transaction = Transaction::with(['user', 'book'])->find($id);

        if (!$transaction) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data transaksi tidak ditemukan',
            ], 404);
        }

        if (!$this->canAccess($transaction)) {
            return $this->forbiddenResponse();
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil mengambil detail data transaksi',
            'data'    => $transaction,
        ], 200);
    }

    // Update data (PUT /api/transactions/{id}) - customer yang sudah login
    public function update(Request $request, string $id): JsonResponse
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data transaksi tidak ditemukan',
            ], 404);
        }

        if (!$this->canAccess($transaction)) {
            return $this->forbiddenResponse();
        }

        $validated = $request->validate([
            'book_id'  => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $updated = DB::transaction(function () use ($transaction, $validated) {
            $oldBook = Book::lockForUpdate()->find($transaction->book_id);

            // Buku bisa tetap sama atau diganti dengan buku lain
            $isSameBook = $oldBook->id === (int) $validated['book_id'];
            $newBook = $isSameBook ? $oldBook : Book::lockForUpdate()->find($validated['book_id']);

            // Stok yang tersedia = stok sekarang (+ pembelian lama kalau bukunya sama)
            $availableStock = $newBook->stock + ($isSameBook ? $transaction->quantity : 0);

            if ($availableStock < $validated['quantity']) {
                return null;
            }

            // Kembalikan stok pembelian lama, lalu kurangi sesuai pembelian baru
            $oldBook->stock += $transaction->quantity;
            $oldBook->save();

            $newBook->stock -= $validated['quantity'];
            $newBook->save();

            $transaction->update([
                'book_id'      => $newBook->id,
                'quantity'     => $validated['quantity'],
                'total_amount' => $newBook->price * $validated['quantity'],
            ]);

            return $transaction;
        });

        if (!$updated) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Stok buku tidak cukup',
            ], 400);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil mengubah data transaksi',
            'data'    => $updated->load(['user', 'book']),
        ], 200);
    }

    // Destroy data (DELETE /api/transactions/{id}) - hanya admin
    public function destroy(string $id): JsonResponse
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data transaksi tidak ditemukan',
            ], 404);
        }

        DB::transaction(function () use ($transaction) {
            // Transaksi dihapus = pembelian dibatalkan, jadi stok buku dikembalikan
            $book = Book::lockForUpdate()->find($transaction->book_id);
            $book->stock += $transaction->quantity;
            $book->save();

            $transaction->delete();
        });

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil menghapus data transaksi',
        ], 200);
    }

    // Customer hanya boleh mengakses transaksinya sendiri, admin boleh semuanya
    private function canAccess(Transaction $transaction): bool
    {
        $user = auth('api')->user();

        return $user->role === 'admin' || (int) $transaction->customer_id === (int) $user->id;
    }

    private function forbiddenResponse(): JsonResponse
    {
        return response()->json([
            'status'  => 'error',
            'message' => 'Akses ditolak. Ini bukan transaksi milik Anda',
        ], 403);
    }
}
