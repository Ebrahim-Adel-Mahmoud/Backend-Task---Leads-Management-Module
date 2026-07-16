<?php

declare(strict_types=1);

namespace App\Enums;

enum DealStatus: string
{
    case New = 'new';
    case InProgress = 'in_progress';
    case Won = 'won';
    case Lost = 'lost';

    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::InProgress => 'In Progress',
            self::Won => 'Won',
            self::Lost => 'Lost',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::New => 'gray',
            self::InProgress => 'blue',
            self::Won => 'green',
            self::Lost => 'red',
        };
    }
}
