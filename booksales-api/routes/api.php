<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\TransactionController;

// ===== Autentikasi (publik) =====
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ===== Publik: Read All & Show (tanpa login) =====
Route::apiResource('/genres', GenreController::class)->only(['index', 'show']);
Route::apiResource('/authors', AuthorController::class)->only(['index', 'show']);

// ===== Wajib login (token JWT) =====
Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // ===== Transaksi: Create, Show, Update (customer yang sudah login) =====
    Route::apiResource('/transactions', TransactionController::class)->only(['store', 'show', 'update']);

    // ===== Hanya admin: Create, Update, Destroy =====
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('/genres', GenreController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('/authors', AuthorController::class)->only(['store', 'update', 'destroy']);

        // Transaksi: Read All & Destroy hanya admin
        Route::apiResource('/transactions', TransactionController::class)->only(['index', 'destroy']);
    });
});

Route::apiResource('/books', BookController::class);