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
}
