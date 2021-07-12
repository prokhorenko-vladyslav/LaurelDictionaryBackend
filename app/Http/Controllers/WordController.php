<?php

namespace App\Http\Controllers;

use App\Http\Resources\WordResource;
use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function index(Request $request)
    {
        return WordResource::collection(
            Word::query()->simplePaginate()
        );
    }
}
