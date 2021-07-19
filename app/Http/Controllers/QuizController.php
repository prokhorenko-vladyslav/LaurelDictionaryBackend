<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Word;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function next()
    {
        $learnedWord = User::current()->learnedWords()->with('word')->inRandomOrder()->first();
        $answers = Word::query()
                        ->where('dictionary_id', $learnedWord->word->dictionary_id)
                        ->inRandomOrder()
                        ->limit(3)
                        ->get([ 'id', 'translation' ]);

        return response([
            'question' => [
                'id' => $learnedWord->word->id,
                'title' => $learnedWord->word->title,
                'answers' => $answers
            ]
        ]);
    }

    public function check(Request $request, Word $word)
    {
        return response([
            'result' => $word->translation === $request->input('translation')
        ]);
    }
}
