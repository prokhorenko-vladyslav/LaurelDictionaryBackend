<?php

namespace App\Http\Controllers;

use App\Models\DailyDictionary;
use App\Models\Dictionary;
use App\Models\User;

class DailyDictionaryController extends Controller
{
    public function store(Dictionary $dictionary)
    {
        User::current()->dailyDictionaries()->firstOrCreate([
            'dictionary_id' => $dictionary->id
        ]);
        return response(null, 201);
    }

    public function destroy(DailyDictionary $dailyDictionary)
    {
        abort_if($dailyDictionary->user_id !== auth()->id(), 403);

        /**
         * Delete daily words from detected daily dictionaries
         */
        User::current()
            ->dailyWords()
            ->whereIn('daily_dictionary_id', $dailyDictionary->id)
            ->delete();

        /**
         * Delete daily dictionaries for specified dictionary
         */
        $dailyDictionary->delete();
    }
}
