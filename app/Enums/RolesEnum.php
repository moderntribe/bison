<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RolesEnum: string implements HasColor, HasLabel
{
    case SUPER_ADMIN = 'super-admin';
    case ADMIN       = 'admin';
    case EDITOR      = 'editor';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SUPER_ADMIN => __('Super Admin'),
            self::ADMIN       => __('Admin'),
            self::EDITOR      => __('Editor'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::SUPER_ADMIN => 'primary',
            self::ADMIN       => 'success',
            self::EDITOR      => 'warning',
        };
    }
}
