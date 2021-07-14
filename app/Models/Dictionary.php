<?php

namespace App\Models;

use App\Traits\PaginationFromLimit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dictionary extends Model
{
    use HasFactory;
    use PaginationFromLimit;

    protected $fillable = [
        'title', 'description'
    ];

    public function fromLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'from_language_id');
    }

    public function toLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'to_language_id');
    }

    public function words(): HasMany
    {
        return $this->hasMany(Word::class);
    }
}
