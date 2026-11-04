<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // customer_id 2 = Customer Booksales (lihat UserSeeder)
        Transaction::create([
            'order_number' => 'ORD-001',
            'customer_id'  => 2,
            'book_id'      => 1,
            'quantity'     => 1,
            'total_amount' => 95000.00,
        ]);

        Transaction::create([
            'order_number' => 'ORD-002',
            'customer_id'  => 2,
            'book_id'      => 2,
            'quantity'     => 2,
            'total_amount' => 176000.00,
        ]);
    }
}
