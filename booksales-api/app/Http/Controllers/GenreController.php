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
}
