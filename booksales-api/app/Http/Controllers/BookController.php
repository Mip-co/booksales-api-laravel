<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController 
{
    public function index()
    {
        $books = Book::with('author')->get();

        return response()->json([
            'success' => true,
            'message' => 'Get All Books',
            'data'    => $books
        ], 200);
    }
}