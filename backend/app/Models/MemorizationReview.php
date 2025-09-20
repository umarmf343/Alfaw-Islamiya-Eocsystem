<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemorizationReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'surah',
        'ayah_range',
        'scheduled_for',
        'interval',
        'ease_factor',
        'repetitions',
        'last_reviewed_at',
    ];

    protected $casts = [
        'scheduled_for' => 'date',
        'last_reviewed_at' => 'datetime',
        'interval' => 'integer',
        'ease_factor' => 'float',
        'repetitions' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
