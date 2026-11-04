<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kalau tabel transactions belum ada: buat baru
        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->string('order_number')->unique();
                // Relasi dengan foreignId: customer_id -> users, book_id -> books
                $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
                $table->unsignedInteger('quantity');
                $table->decimal('total_amount', 10, 2);
                $table->timestamps();
            });

            return;
        }

        // Kalau tabel transactions sudah ada (berisi data): hanya tambah kolom yang belum ada
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'quantity')) {
                $table->unsignedInteger('quantity')->default(1)->after('book_id');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
