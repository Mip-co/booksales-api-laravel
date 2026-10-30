<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;

// Route Genre (index, store, show, update, destroy)
Route::apiResource('/genres', GenreController::class);

// Route Author (index, store, show, update, destroy)
Route::apiResource('/authors', AuthorController::class);

Route::apiResource('/books', BookController::class);