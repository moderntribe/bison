<?php

namespace App\Models;

use App\Enums\RolesEnum;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * @property RolesEnum $name
 */
class Role extends SpatieRole
{
    protected function casts(): array
    {
        return [
            'name' => RolesEnum::class,
        ];
    }
}
