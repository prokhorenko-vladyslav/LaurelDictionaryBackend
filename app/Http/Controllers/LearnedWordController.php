<?php

namespace App\Http\Controllers;

use App\Models\LearnedWord;
use App\Models\User;
use App\Models\Word;
use Illuminate\Http\Request;

class LearnedWordController extends Controller
{
    public function store(Request $request, Word $word)
    {
        $learnedWord = new LearnedWord;
        $learnedWord->word()->associate($word);
        $learnedWord->user()->associate(User::current());
        $learnedWord->saveOrFail();
    }
}
