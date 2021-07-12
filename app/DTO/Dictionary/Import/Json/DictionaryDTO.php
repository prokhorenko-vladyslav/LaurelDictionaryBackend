<?php


namespace App\DTO\Dictionary\Import\Json;

/**
 * Class DictionaryDTO
 * @package App\DTO\Dictionary
 */
class DictionaryDTO
{
    protected string $title;
    protected string $description;
    protected LanguageDTO $fromLanguage;
    protected LanguageDTO $toLanguage;
    protected WordsCollectionDTO $wordsCollection;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return LanguageDTO
     */
    public function getFromLanguage(): LanguageDTO
    {
        return $this->fromLanguage;
    }

    /**
     * @return LanguageDTO
     */
    public function getToLanguage(): LanguageDTO
    {
        return $this->toLanguage;
    }

    /**
     * @return WordsCollectionDTO
     */
    public function getWordsCollection(): WordsCollectionDTO
    {
        return $this->wordsCollection;
    }

    public function __construct(
        string $title, string $description,
        LanguageDTO $fromLanguage, LanguageDTO $toLanguage,
        WordsCollectionDTO $wordsCollection
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->fromLanguage = $fromLanguage;
        $this->toLanguage = $toLanguage;
        $this->wordsCollection = $wordsCollection;
    }
}
