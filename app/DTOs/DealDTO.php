<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\DealStatus;
use Illuminate\Foundation\Http\FormRequest;

readonly final class DealDTO
{
    public function __construct(
        public int $leadId,
        public string $productService,
        public string $budget,
        public DealStatus $status,
        public ?string $notes,
    ) {}

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            leadId: (int) $request->validated('lead_id'),
            productService: $request->validated('product_service'),
            budget: (string) $request->validated('budget'),
            status: DealStatus::from($request->validated('status')),
            notes: $request->validated('notes'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return [
            'lead_id' => $this->leadId,
            'product_service' => $this->productService,
            'budget' => $this->budget,
            'status' => $this->status,
            'notes' => $this->notes,
        ];
    }
}
