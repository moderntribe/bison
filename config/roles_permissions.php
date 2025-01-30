<?php

use App\Enums\RolesEnum;

return [

    'prefix' => [
        'view-any',
        'view',
        'create',
        'update',
        'delete',
        'restore',
        'force-delete',
    ],

    RolesEnum::ADMIN->value => [
        'admin.view',
        'admin.users.view-any',
        'admin.users.view',
        'admin.users.create',
        'admin.users.update',
        'admin.users.delete',
        'admin.users.restore',
        'admin.users.force-delete',
    ],

    RolesEnum::EDITOR->value => [
    ],
];
