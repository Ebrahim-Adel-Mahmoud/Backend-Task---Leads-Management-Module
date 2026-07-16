<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\ActionType;
use Illuminate\Foundation\Http\FormRequest;

readonly final class LeadActionDTO
{
    public function __construct(
        public int $dealId,
        public ActionType $type,
        public string $scheduledAt,
        public ?string $notes,
    ) {}

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            dealId: (int) $request->validated('deal_id'),
            type: ActionType::from($request->validated('type')),
            scheduledAt: $request->validated('scheduled_at'),
            notes: $request->validated('notes'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return [
            'deal_id' => $this->dealId,
            'type' => $this->type,
            'scheduled_at' => $this->scheduledAt,
            'notes' => $this->notes,
        ];
    }
}
