<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assignment_id',
        'surah',
        'ayah_range',
        'audio_path',
        'audio_feedback_path',
        'expected_text',
        'feedback',
        'score',
        'hasanat',
        'status',
    ];

    protected $casts = [
        'feedback' => 'array',
        'score' => 'float',
        'hasanat' => 'integer',
        'status' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }
}
