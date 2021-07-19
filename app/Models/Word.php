<?php

namespace App\Models;

use App\Traits\PaginationFromLimit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Word extends Model
{
    use HasFactory;
    use PaginationFromLimit;

    protected $fillable = [
        'title', 'translation'
    ];

    public function dictionary(): BelongsTo
    {
        return $this->belongsTo(Dictionary::class);
    }

    public function audio(): BelongsTo
    {
        return $this->belongsTo(WordAudio::class, 'word_audio_id');
    }
}
