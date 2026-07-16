<?php

declare(strict_types=1);

namespace App\Support;

final class ValidationRules
{
    /**
     * @return list<string|\Illuminate\Contracts\Validation\ValidationRule>
     */
    public static function name(bool $required = true): array
    {
        return $required
            ? ['required', 'string', 'max:255']
            : ['nullable', 'string', 'max:255'];
    }

    /**
     * @return list<string|\Illuminate\Contracts\Validation\ValidationRule>
     */
    public static function email(bool $required = false): array
    {
        return $required
            ? ['required', 'email', 'max:255']
            : ['nullable', 'email', 'max:255'];
    }

    /**
     * @return list<string|\Illuminate\Contracts\Validation\ValidationRule>
     */
    public static function phone(bool $required = true): array
    {
        return $required
            ? ['required', 'string', 'max:50']
            : ['nullable', 'string', 'max:50'];
    }

    /**
     * @return list<string|\Illuminate\Contracts\Validation\ValidationRule>
     */
    public static function notes(): array
    {
        return ['nullable', 'string'];
    }

    /**
     * @return list<string|\Illuminate\Contracts\Validation\ValidationRule>
     */
    public static function address(): array
    {
        return ['nullable', 'string'];
    }

    /**
     * @return list<string|\Illuminate\Contracts\Validation\ValidationRule>
     */
    public static function productService(): array
    {
        return ['required', 'string', 'max:255'];
    }

    /**
     * @return list<string|\Illuminate\Contracts\Validation\ValidationRule>
     */
    public static function budget(): array
    {
        return ['required', 'numeric', 'min:0'];
    }

    /**
     * @return list<string|\Illuminate\Contracts\Validation\ValidationRule>
     */
    public static function foreignId(string $table): array
    {
        return ['required', 'integer', "exists:{$table},id"];
    }

    /**
     * @return list<string|\Illuminate\Contracts\Validation\ValidationRule>
     */
    public static function scheduledAt(): array
    {
        return ['required', 'date'];
    }
}
