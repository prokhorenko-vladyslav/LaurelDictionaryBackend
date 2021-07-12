<?php


namespace App\Parsers\Dictionary\Import;


use App\DTO\Dictionary\Import\Json\DictionaryDTO;
use App\DTO\Dictionary\Import\Json\LanguageDTO;
use App\DTO\Dictionary\Import\Json\WordDTO;
use App\DTO\Dictionary\Import\Json\WordsCollectionDTO;

class JsonParser
{
    protected string $data;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function parse(): DictionaryDTO
    {
        $json = json_decode($this->data);
        $dictionaryTitle = $json->title;
        $dictionaryDescription = $json->description ?? '';
        $dictionaryLanguageFrom = new LanguageDTO($json->from_language);
        $dictionaryLanguageTo = new LanguageDTO($json->to_language);
        $dictionaryWords = new WordsCollectionDTO;

        foreach ($json->words as $word) {
            $dictionaryWords->attach(
                new WordDTO($word->title, $word->translation)
            );
        }

        return new DictionaryDTO(
            $dictionaryTitle, $dictionaryDescription,
            $dictionaryLanguageFrom, $dictionaryLanguageTo,
            $dictionaryWords
        );
    }
}
