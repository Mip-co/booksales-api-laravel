<?php

namespace App\Http\Controllers;

use App\Models\Genre;

class GenreController
{
    public function index()
    {
        $genres = Genre::getAllData();
        return view('genres.index', compact('genres'));
    }
}