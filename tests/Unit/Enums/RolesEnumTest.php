<?php

use App\Enums\RolesEnum;

describe('RolesEnum', function () {
    it('has expected cases', function () {
        expect(RolesEnum::cases())->toHaveCount(3)
            ->and(RolesEnum::SUPER_ADMIN->value)->toBe('super-admin')
            ->and(RolesEnum::ADMIN->value)->toBe('admin')
            ->and(RolesEnum::EDITOR->value)->toBe('editor');
    });

    it('returns human-readable labels', function (RolesEnum $role, string $label) {
        expect($role->getLabel())->toBe($label);
    })->with([
        'super admin' => [RolesEnum::SUPER_ADMIN, 'Super Admin'],
        'admin'       => [RolesEnum::ADMIN, 'Admin'],
        'editor'      => [RolesEnum::EDITOR, 'Editor'],
    ]);

    it('returns filament colors', function (RolesEnum $role, string $color) {
        expect($role->getColor())->toBe($color);
    })->with([
        'super admin' => [RolesEnum::SUPER_ADMIN, 'primary'],
        'admin'       => [RolesEnum::ADMIN, 'success'],
        'editor'      => [RolesEnum::EDITOR, 'warning'],
    ]);
});
