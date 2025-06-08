<?php

namespace App\Traits;

use App\Models\PuzzleSubmission;
use Illuminate\Support\Facades\DB;

trait PuzzleHelper
{
    /**
     * This will check submitted work can construct from the string
     * @param $string
     * @param $match
     * @return bool
     */
    public function validateString($string, $match)
    {
        $allLettersPresent = true;
        $matchChars = count_chars($match, 1);

        foreach ($matchChars as $ascii => $count) {
            $char = chr($ascii);
            if (substr_count($string, $char) < $count) {
                $allLettersPresent = false;
                break;
            }
        }
        return $allLettersPresent;
    }

    /**
     * This will regenerate the random string while removing the submitted letters
     * @param $string
     * @param $answer
     * @return array|mixed|string|string[]
     */
    public function regenerateString($string, $answer)
    {
        foreach (str_split($answer) as $char) {
            $pos = strpos($string, $char);
            if ($pos !== false) {
                $string = substr_replace($string, '', $pos, 1);
            }
        }
        return $string;
    }

    /**
     * @return mixed
     */
    public function getLargeWordWithScore()
    {
        return PuzzleSubmission::select('word', DB::raw('MAX(score) as score'))
            ->with(['puzzle'])
            ->groupBy('word')
            ->orderByDesc('score')
            ->take(10)
            ->get()
            ->map(function ($submission) {
                return [
                    'word' => $submission->word,
                    'score' => $submission->score,
                ];
            });
    }

    /**
     * @return mixed
     */
    public function getLeadersBoard()
    {
        return PuzzleSubmission::select(
            'users.id as user_id',
            'users.email',
            'users.name',
            DB::raw('GROUP_CONCAT(DISTINCT puzzle_submissions.word) as words'),
            DB::raw('SUM(puzzle_submissions.score) as score')
        )
            ->join('puzzles', 'puzzle_submissions.puzzle_id', '=', 'puzzles.id')
            ->join('users', 'puzzles.user_id', '=', 'users.id')
            ->groupBy('users.id', 'users.email', 'users.name')
            ->orderByDesc('score')
            ->limit(10)
            ->get();
    }
}