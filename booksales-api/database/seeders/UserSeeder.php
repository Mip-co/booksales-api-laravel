<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Password otomatis di-hash oleh cast "hashed" di model User
        User::create([
            'name'     => 'Admin Booksales',
            'email'    => 'admin@booksales.com',
            'password' => 'admin12345',
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Customer Booksales',
            'email'    => 'customer@booksales.com',
            'password' => 'customer12345',
            'role'     => 'customer',
        ]);
    }
}