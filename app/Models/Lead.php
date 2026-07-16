<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'notes',
    ];

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }
}
