<?php

namespace App\Models;

class Author
{
    public static function getAllData()
    {
        return [
            ['id' => 1, 'name' => 'J.K. Rowling', 'photo' => 'jk_rowling.jpg', 'bio' => 'British author, best known for the Harry Potter series.'],
            ['id' => 2, 'name' => 'George R.R. Martin', 'photo' => 'george_rr_martin.jpg', 'bio' => 'American novelist and short story writer, known for A Song of Ice and Fire.'],
            ['id' => 3, 'name' => 'Isaac Asimov', 'photo' => 'isaac_asimov.jpg', 'bio' => 'American author and professor of biochemistry, known for his works in science fiction.'],
            ['id' => 4, 'name' => 'Andrea Hirata', 'photo' => 'andrea_hirata.jpg', 'bio' => 'Novelis Indonesia, penulis Laskar Pelangi yang telah diterjemahkan ke banyak bahasa.'],
            ['id' => 5, 'name' => 'Tere Liye', 'photo' => 'tere_liye.jpg', 'bio' => 'Penulis novel Indonesia, dikenal lewat serial Bumi.'],
            ['id' => 6, 'name' => 'Agatha Christie', 'photo' => 'agatha_christie.jpg', 'bio' => 'Penulis Inggris, dijuluki ratu novel misteri.'],
            ['id' => 7, 'name' => 'Stephen King', 'photo' => 'stephen_king.jpg', 'bio' => 'Penulis Amerika, dikenal lewat novel horor dan thriller.'],
            ['id' => 8, 'name' => 'Dale Carnegie', 'photo' => 'dale_carnegie.jpg', 'bio' => 'Penulis dan pembicara Amerika di bidang pengembangan diri.'],
        ];
    }
}