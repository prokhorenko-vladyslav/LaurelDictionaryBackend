<?php


namespace App\DTO\Dictionary\Import\Json;


use Illuminate\Support\Collection;

/**
 * Class WordsCollectionDTO
 * @package App\DTO\Dictionary
 */
class WordsCollectionDTO
{
    protected Collection $words;

    /**
     * @return Collection
     */
    public function getWords(): Collection
    {
        return $this->words;
    }

    public function __construct()
    {
        $this->words = collect();
    }

    public function attach(WordDTO $word): self
    {
        $this->words->push($word);
        return $this;
    }
}
