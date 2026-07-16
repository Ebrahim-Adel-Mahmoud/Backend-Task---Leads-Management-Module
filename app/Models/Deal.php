<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DealStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deal extends Model
{
    protected $fillable = [
        'lead_id',
        'product_service',
        'budget',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'status' => DealStatus::class,
            'budget' => 'decimal:2',
        ];
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function actions(): HasMany
    {
        return $this->hasMany(LeadAction::class);
    }
}
