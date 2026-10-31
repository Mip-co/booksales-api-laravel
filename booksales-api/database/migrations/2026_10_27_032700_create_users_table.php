<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kalau tabel users belum ada: buat baru
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->enum('role', ['admin', 'customer'])->default('customer');
                $table->timestamp('last_access')->nullable();
                $table->timestamps();
            });

            return;
        }

        // Kalau tabel users sudah ada (berisi data): hanya tambah kolom yang belum ada
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'customer'])->default('customer');
            }
            if (!Schema::hasColumn('users', 'last_access')) {
                $table->timestamp('last_access')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'role')) {
                    $table->dropColumn('role');
                }
                if (Schema::hasColumn('users', 'last_access')) {
                    $table->dropColumn('last_access');
                }
            });
        }
    }
};