<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController
{
    public function index()
    {
        $authors = Author::getAllData();
        return view('authors.index', compact('authors'));
    }
}