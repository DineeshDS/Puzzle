<?php

namespace App\Http\Controllers;

use App\Enum\DefaultValue;
use App\Models\PuzzleSubmission;
use App\Services\PuzzleGeneratorService;
use App\Traits\PuzzleHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PuzzleController extends Controller
{
    use PuzzleHelper;

    /**
     * @param PuzzleGeneratorService $puzzleGeneratorService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(PuzzleGeneratorService $puzzleGeneratorService)
    {
        $title = $tab = 'Puzzle';
        $randomString = $puzzleGeneratorService->generateRandomLetters(DefaultValue::DEFAULT_STRING_LENGTH->value);

        $puzzle = Auth::user()->puzzle()->with(['submissions'])->firstOrCreate(['user_id' => Auth::user()->id], [
            'original_string' => $randomString,
            'current_string' => $randomString
        ]);

        return view('dashboard', compact('title', 'tab', 'puzzle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PuzzleGeneratorService $puzzleGeneratorService)
    {
        if ($request->has('answer') && $request->input('answer') != null) {

            $word = trim(strtolower($request->input('answer')));
            $puzzle = Auth::user()->puzzle;
            if (!$this->validateString($puzzle->current_string, $word)) {
                return $this->apiResponse([], "'$word' is not possible to create from letter pool string '$puzzle->current_string'", 400);
            }
            if ($puzzle->submissions()->where('word', $word)->count()) {
                return $this->apiResponse([], '<p>The word <b style="color: red">' . $word . '</b> you submitted already!</p>', 500);
            }
            if (!$puzzleGeneratorService->isValidEnglishWord($word)) {
                return $this->apiResponse([], 'Invalid English word', 400);
            }
            try {
                DB::beginTransaction();
                //save answer and update letter pool string
                $puzzle->submissions()->create([
                    'word' => $word,
                    'score' => strlen($word)
                ]);

                $currentString = $this->regenerateString($puzzle->current_string, $word);
                $puzzleData = ['current_string' => $currentString];
                if ($currentString == "") {
                    $puzzleData['status'] = 1;
                }
                $puzzle->update($puzzleData);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Failed to save puzzle submission or update string: ' . $e->getMessage());
                return $this->apiResponse([], 'Something went wrong', 500);
            }
            return $this->apiResponse([], 'Successfully submitted your answer', 200);

        } else {
            return $this->apiResponse([], 'Please enter a valid word', 500);
        }
    }

    /**
     * Display the leader boards
     */
    public function leaderBoard()
    {
        $title = $tab = 'Leader Board';
        $lists = $this->getLeadersBoard();

        return view('leader', compact('title', 'tab', 'lists'));
    }

    public function endGame(Request $request)
    {
        if ($request->has('answer') && $request->input('answer') == 'end') {
            $puzzle = Auth::user()->puzzle;
            $score = $puzzle->total_score;
            $total = $puzzle->submissions->count();

            $puzzle->update(['status' => 1]);
            return $this->apiResponse([], '<p>Congratulations You have successfully completed your puzzle <br><strong>Your score </strong>' . $score . '.</p> <p>You have submitted <b>' . $total . ' word(s)<b></b></p>', 200);
        }
        return $this->apiResponse([], 'Something went wrong', 500);
    }

}
