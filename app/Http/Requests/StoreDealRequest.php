<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\DealStatus;
use App\Support\ValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'product_service' => trim((string) $this->input('product_service', '')),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'lead_id' => ValidationRules::foreignId('leads'),
            'product_service' => ValidationRules::productService(),
            'budget' => ValidationRules::budget(),
            'status' => ['required', Rule::enum(DealStatus::class)],
            'notes' => ValidationRules::notes(),
        ];
    }
}
