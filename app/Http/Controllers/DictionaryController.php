<?php

namespace App\Http\Controllers;

use App\Http\Resources\DictionaryResource;
use App\Models\Dictionary;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DictionaryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $dictionaries = Dictionary::query()
                            ->withCount('words')
                            ->with(['fromLanguage', 'toLanguage'])
                            ->paginate();

        return DictionaryResource::collection($dictionaries);
    }
}
