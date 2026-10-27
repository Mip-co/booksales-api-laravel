<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('books')->insert([
            ['id' => 1, 'title' => 'Bumi', 'description' => 'Novel petualangan dunia paralel.', 'price' => 95000.00, 'stock' => 15, 'cover_photo' => 'bumi.jpg', 'genre_id' => 1, 'author_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'title' => 'Laskar Pelangi', 'description' => 'Kisah inspiratif anak-anak Belitung.', 'price' => 88000.00, 'stock' => 20, 'cover_photo' => 'laskar_pelangi.jpg', 'genre_id' => 1, 'author_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'title' => 'Bumi Manusia', 'description' => 'Karya legendaris Tetralogi Buru.', 'price' => 105000.00, 'stock' => 10, 'cover_photo' => 'bumi_manusia.jpg', 'genre_id' => 1, 'author_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'title' => 'Supernova', 'description' => 'Serial fiksi ilmiah modern.', 'price' => 90000.00, 'stock' => 12, 'cover_photo' => 'supernova.jpg', 'genre_id' => 3, 'author_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'title' => 'Negeri 5 Menara', 'description' => 'Novel inspiratif impian anak pesantren.', 'price' => 85000.00, 'stock' => 18, 'cover_photo' => 'negeri5menara.jpg', 'genre_id' => 4, 'author_id' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}