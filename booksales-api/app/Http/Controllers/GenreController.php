<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GenreController
{
    // Read all data (GET /api/genres)
    public function index(): JsonResponse
    {
        $genres = Genre::all();

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil mengambil seluruh data genre',
            'data'    => $genres,
        ], 200);
    }

    // Create data (POST /api/genres)
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $genre = Genre::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil menambahkan data genre',
            'data'    => $genre,
        ], 201);
    }

    // Show data (GET /api/genres/{id})
    public function show(string $id): JsonResponse
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data genre tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil mengambil detail data genre',
            'data'    => $genre,
        ], 200);
    }

    // Update data (PUT /api/genres/{id})
    public function update(Request $request, string $id): JsonResponse
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data genre tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $genre->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil mengubah data genre',
            'data'    => $genre,
        ], 200);
    }

    // Destroy data (DELETE /api/genres/{id})
    public function destroy(string $id): JsonResponse
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data genre tidak ditemukan',
            ], 404);
        }

        $genre->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil menghapus data genre',
        ], 200);
    }
}