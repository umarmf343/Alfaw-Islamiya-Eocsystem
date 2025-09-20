<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'criteria',
    ];

    protected $casts = [
        'criteria' => 'array',
    ];

    public function awards(): HasMany
    {
        return $this->hasMany(UserBadge::class);
    }
}
