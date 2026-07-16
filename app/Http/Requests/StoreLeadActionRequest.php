<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\ActionType;
use App\Support\ValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLeadActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'deal_id' => ValidationRules::foreignId('deals'),
            'type' => ['required', Rule::enum(ActionType::class)],
            'scheduled_at' => ValidationRules::scheduledAt(),
            'notes' => ValidationRules::notes(),
        ];
    }
}
