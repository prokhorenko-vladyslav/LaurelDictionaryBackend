<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    public function next()
    {
        $learnedWord = User::current()->learnedWords()->with('word')->inRandomOrder()->first();
        $answers = Word::query()
                        ->where('dictionary_id', $learnedWord->word->dictionary_id)
                        ->where('id', '!=', $learnedWord->word->id)
                        ->inRandomOrder()
                        ->limit(3)
                        ->get([ 'id', 'translation' ]);

        $answers->push([
            'id' => $learnedWord->word->id,
            'translation' => $learnedWord->word->translation
        ]);
        $answers->shuffle();

        return response([
            'question' => [
                'id' => $learnedWord->word->id,
                'title' => Str::ucfirst($learnedWord->word->title),
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
