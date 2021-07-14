<?php

namespace App\Models;

use App\Traits\PaginationFromLimit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    use HasFactory;
    use PaginationFromLimit;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
