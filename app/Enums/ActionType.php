<?php

declare(strict_types=1);

namespace App\Enums;

enum ActionType: string
{
    case Call = 'call';
    case Meeting = 'meeting';

    public function label(): string
    {
        return match ($this) {
            self::Call => 'Call',
            self::Meeting => 'Meeting',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Call => 'purple',
            self::Meeting => 'orange',
        };
    }
}
