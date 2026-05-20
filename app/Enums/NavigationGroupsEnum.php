<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum NavigationGroupsEnum: string implements HasLabel
{
    case ADMIN = 'admin';

    public function getLabel(): string
    {
        return match ($this) {
            self::ADMIN => __('Organization'),
        };
    }
}
