<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasanatLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recitation_id',
        'points',
        'reason',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recitation(): BelongsTo
    {
        return $this->belongsTo(Recitation::class);
    }
}
