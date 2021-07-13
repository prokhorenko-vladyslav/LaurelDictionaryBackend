<?php

namespace App\Http\Controllers;

use App\Http\Resources\WordResource;
use App\Models\Dictionary;
use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function index(Dictionary $dictionary)
    {
        $words = $dictionary->words()->with('audio')->paginate();
        return WordResource::collection($words);
    }
}
