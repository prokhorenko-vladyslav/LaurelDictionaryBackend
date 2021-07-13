<?php

namespace App\Http\Controllers;

use App\Http\Resources\WordResource;
use App\Models\DailyDictionary;
use Illuminate\Http\Request;

class DailyWordController extends Controller
{
    public function index(DailyDictionary $dailyDictionary)
    {
        abort_if($dailyDictionary->user_id !== auth()->id(), 403);

        $words = $dailyDictionary->dailyWords()->with('audio')->paginate();
        return WordResource::collection($words);
    }
}
