<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::query()->firstOrCreate([
            'title' => 'English',
            'alias' => 'en'
        ]);

        Language::query()->firstOrCreate([
            'title' => 'Русский',
            'alias' => 'ru'
        ]);
    }
}
