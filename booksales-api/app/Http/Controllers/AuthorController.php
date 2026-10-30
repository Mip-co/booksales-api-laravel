<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorController
{
    // Read all data (GET /api/authors)
    public function index(): JsonResponse
    {
        $authors = Author::all();

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil mengambil seluruh data author',
            'data'    => $authors,
        ], 200);
    }

    // Create data (POST /api/authors)
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'photo' => 'nullable|string|max:255',
            'bio'   => 'nullable|string',
        ]);

        $author = Author::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil menambahkan data author',
            'data'    => $author,
        ], 201);
    }

    // Show data (GET /api/authors/{id})
    public function show(string $id): JsonResponse
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data author tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil mengambil detail data author',
            'data'    => $author,
        ], 200);
    }

    // Update data (PUT /api/authors/{id})
    public function update(Request $request, string $id): JsonResponse
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data author tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'photo' => 'nullable|string|max:255',
            'bio'   => 'nullable|string',
        ]);

        $author->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil mengubah data author',
            'data'    => $author,
        ], 200);
    }

    // Destroy data (DELETE /api/authors/{id})
    public function destroy(string $id): JsonResponse
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data author tidak ditemukan',
            ], 404);
        }

        $author->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil menghapus data author',
        ], 200);
    }
}