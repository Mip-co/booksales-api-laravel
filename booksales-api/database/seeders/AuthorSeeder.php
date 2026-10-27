<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('authors')->insert([
            ['id' => 1, 'name' => 'Tere Liye', 'photo' => 'tereliye.jpg', 'bio' => 'Penulis novel populer asal Indonesia.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Andrea Hirata', 'photo' => 'andrea.jpg', 'bio' => 'Penulis novel Laskar Pelangi.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Pramoedya Ananta Toer', 'photo' => 'pramoedya.jpg', 'bio' => 'Sastrawan legendaris Indonesia, penulis Tetralogi Buru.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Dee Lestari', 'photo' => 'deelestari.jpg', 'bio' => 'Penulis serial terkenal Supernova.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Ahmad Fuadi', 'photo' => 'afuadi.jpg', 'bio' => 'Penulis novel inspiratif Negeri 5 Menara.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}