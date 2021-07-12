<?php

namespace App\Console\Commands\Dictionary;

use App\DTO\Dictionary\Import\Json\DictionaryDTO;
use App\DTO\Dictionary\Import\Json\WordDTO;
use App\Models\Dictionary;
use App\Models\Language;
use App\Models\Word;
use App\Parsers\Dictionary\Import\JsonParser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dictionary:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports dictionary into database using specified format and file with data.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = $this->argument('file');
        $fullPath = Storage::disk('dictionaries')->path($path);
        if (!File::exists($fullPath)) {
            $this->error('File has not been found');
            return 0;
        }

        $extension = File::extension($fullPath);
        switch ($extension) {
            case "json" :
                $parser = new JsonParser(File::get($fullPath));
                $this->importJsonFile($parser->parse());
                $this->info('Dictionary has been imported');
                break;
            default:
                $this->error('File has unsupported format');
                return 0;
        }
        return 0;
    }

    /**
     * @throws \Throwable
     */
    protected function importJsonFile(DictionaryDTO $dictionaryDTO)
    {
        DB::beginTransaction();

        $languageFrom = Language::query()->where('alias', $dictionaryDTO->getFromLanguage()->getAlias())->firstOrFail();
        $languageTo = Language::query()->where('alias', $dictionaryDTO->getToLanguage()->getAlias())->firstOrFail();
        $dictionary = new Dictionary([
            'title' => $dictionaryDTO->getTitle(),
            'description' => $dictionaryDTO->getDescription()
        ]);
        $dictionary->fromLanguage()->associate($languageFrom);
        $dictionary->toLanguage()->associate($languageTo);
        $dictionary->saveOrFail();

        $words = $dictionaryDTO->getWordsCollection()->getWords();
        $words->transform(function (WordDTO $word) use($dictionary) {
            $wordArr = $word->toArray();
            $wordArr['dictionary_id'] = $dictionary->id;
            $wordArr['created_at'] = now()->toDateTimeString();
            $wordArr['updated_at'] = now()->toDateTimeString();
            return $wordArr;
        });
        Word::query()->insert($words->toArray());

        DB::commit();
    }
}
