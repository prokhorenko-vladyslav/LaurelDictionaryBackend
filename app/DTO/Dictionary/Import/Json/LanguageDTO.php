<?php


namespace App\DTO\Dictionary\Import\Json;


class LanguageDTO
{
    protected string $alias;

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    public function __construct(string $alias)
    {
        $this->alias = $alias;
    }
}
