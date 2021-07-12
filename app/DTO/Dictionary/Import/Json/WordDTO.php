<?php


namespace App\DTO\Dictionary\Import\Json;


use Illuminate\Support\Collection;

/**
 * Class WordDTO
 * @package App\DTO\Dictionary
 */
class WordDTO
{
    protected string $title;

    protected string $translation;

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
    public function getTranslation(): string
    {
        return $this->translation;
    }

    public function __construct(string $title, string $translation)
    {
        $this->title = $title;
        $this->translation = $translation;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->getTitle(),
            'translation' => $this->getTranslation(),
        ];
    }
}
