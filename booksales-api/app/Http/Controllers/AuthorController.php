<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController
{
    public function index()
    {
        // Ubah dari Author::getAllData() menjadi Author::all()
        $authors = Author::all(); 
        
        return view('authors.index', compact('authors'));
    }
}