<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DictionaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'words_count' => $this->wordsCount ?? 0,/*
            'from_language' => new LanguageResource($this->fromLanguage),
            'to_language' => new LanguageResource($this->toLanguage),*/
        ];
    }
}
