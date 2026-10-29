<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('genres')->insert([
            ['id' => 1, 'name' => 'Fiction', 'description' => 'A literary work based on the imagination and not necessarily on fact.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Non-Fiction', 'description' => 'A literary work based on facts and real events.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Science Fiction', 'description' => 'A genre that deals with imaginative and futuristic concepts.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Inspirational', 'description' => 'Genre yang berisi kisah penuh motivasi dan semangat.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Fantasy', 'description' => 'Genre fiksi dengan unsur sihir, makhluk mitos, dan dunia imajinatif.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Mystery', 'description' => 'Genre dengan teka-teki dan pemecahan kasus.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Biography', 'description' => 'Genre yang menceritakan kisah hidup seseorang.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Horror', 'description' => 'Genre yang bertujuan menimbulkan rasa takut dan tegang.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
