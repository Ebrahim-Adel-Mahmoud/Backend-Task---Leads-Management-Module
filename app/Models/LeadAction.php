<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ActionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadAction extends Model
{
    protected $table = 'lead_actions';

    protected $fillable = [
        'deal_id',
        'type',
        'scheduled_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'type' => ActionType::class,
            'scheduled_at' => 'datetime',
        ];
    }

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }
}
