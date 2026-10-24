<?php

namespace App\Models;

class Genre
{
    public static function getAllData()
    {
        return [
            ['id' => 1, 'name' => 'Fiction', 'description' => 'A literary work based on the imagination and not necessarily on fact.'],
            ['id' => 2, 'name' => 'Non-Fiction', 'description' => 'A literary work based on facts and real events.'],
            ['id' => 3, 'name' => 'Science Fiction', 'description' => 'A genre that deals with imaginative and futuristic concepts.'],
            ['id' => 5, 'name' => 'Fantasy', 'description' => 'Genre fiksi dengan unsur sihir, makhluk mitos, dan dunia imajinatif.'],
            ['id' => 6, 'name' => 'Mystery', 'description' => 'Genre dengan teka-teki dan pemecahan kasus.'],
            ['id' => 7, 'name' => 'Biography', 'description' => 'Genre yang menceritakan kisah hidup seseorang.'],
            ['id' => 8, 'name' => 'Horror', 'description' => 'Genre yang bertujuan menimbulkan rasa takut dan tegang.'],
        ];
    }
}