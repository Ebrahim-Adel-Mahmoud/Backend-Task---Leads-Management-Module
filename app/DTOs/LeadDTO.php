<?php

declare(strict_types=1);

namespace App\DTOs;

use Illuminate\Foundation\Http\FormRequest;

readonly final class LeadDTO
{
    public function __construct(
        public string $name,
        public string $phone,
        public ?string $email,
        public ?string $address,
        public ?string $notes,
    ) {}

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            phone: $request->validated('phone'),
            email: $request->validated('email'),
            address: $request->validated('address'),
            notes: $request->validated('notes'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'notes' => $this->notes,
        ];
    }
}
