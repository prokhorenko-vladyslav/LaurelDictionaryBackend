<?php

namespace App\Console\Commands\Dictionary;

use App\Models\Word;
use App\Models\WordAudio;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FetchWordAudio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dictionary:fetch-word-audio {dictionary}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches word audio from Britlex service';

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
        $words = Word::query()
                    ->where('dictionary_id', intval($this->argument('dictionary')))
                    ->whereNull('word_audio_id')
                    ->get();
        $this->withProgressBar($words, function (Word $word) {
            $title = preg_replace('/[^a-z]/', '_', trim(strtolower($word->title)));
            $audioUrl = $this->createAudioUrl($title);
            $word->audio()->delete();
            $wordAudio = WordAudio::query()->create([
                'filename' => $this->downloadFile($audioUrl, $title)
            ]);
            $word->audio()->associate($wordAudio);
            $word->saveOrFail();
        });

        $this->info("\nAudio fetching has been finished");
        return 0;
    }

    protected function createAudioUrl(string $title): string
    {
        return "https://britlex.ru/mp3/{$title}.mp3";
    }

    protected function downloadFile(string $url, string $title): string
    {
        $fileName = "$title.mp3";
        $content = file_get_contents($url);
        $isDownloaded = Storage::disk('words-audio')->put($fileName, $content);
        if (!$isDownloaded) {
            throw new \Exception('Audio has not been downloaded');
        }

        return $fileName;
    }
}
