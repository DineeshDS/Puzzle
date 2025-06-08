<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PuzzleGeneratorService
{
    /**
     * @param $length
     * @return string
     */
    public function generateRandomLetters($length)
    {
        $frequency = str_split('eeeeeeaaaaiiiooouuullnnssttrrrdddggbbccmmppffhhvvwwyykkjjxqqzz');
        $letters = '';

        for ($i = 0; $i < $length; $i++) {
            $letters .= $frequency[array_rand($frequency)];
        }

        return str_shuffle($letters);
    }

    /**
     * @param $word
     * @return bool
     */
    public function isValidEnglishWord($word)
    {
        $response = Http::get("https://api.dictionaryapi.dev/api/v2/entries/en/{$word}");

        return $response->ok(); // HTTP 200 means word is valid
    }

}

