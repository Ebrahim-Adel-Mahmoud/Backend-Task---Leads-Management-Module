<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Support\ValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => trim((string) $this->input('phone', '')),
            'email' => $this->filled('email') ? strtolower(trim((string) $this->input('email'))) : null,
            'name' => trim((string) $this->input('name', '')),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ValidationRules::name(),
            'phone' => ValidationRules::phone(),
            'email' => ValidationRules::email(),
            'address' => ValidationRules::address(),
            'notes' => ValidationRules::notes(),
        ];
    }
}
