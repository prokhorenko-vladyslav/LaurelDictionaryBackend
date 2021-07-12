<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WordAudio extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename'
    ];

    public function word(): HasOne
    {
        return $this->hasOne(Word::class);
    }
}
