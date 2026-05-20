<?php

use App\Enums\RolesEnum;
use App\Models\User;
use Filament\Facades\Filament;

describe('User model', function () {
    beforeEach(function () {
        seedRolesAndPermissions();
    });

    it('allows all users to access the dashboard panel', function () {
        $user = User::factory()->create();

        expect($user->canAccessPanel(Filament::getPanel('dashboard')))->toBeTrue();
    });

    it('uses the user email as the app authentication holder name', function () {
        $user = User::factory()->create([
            'email' => 'jane@example.com',
        ]);

        expect($user->getAppAuthenticationHolderName())->toBe('jane@example.com');
    });

    it('generates a ui-avatars url for the filament avatar', function () {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
        ]);

        expect($user->getFilamentAvatarUrl())
            ->toStartWith('https://ui-avatars.com/api/')
            ->toContain('name=');
    });

    it('allows super admins to impersonate other users', function () {
        $superAdmin = createUserWithRole(RolesEnum::SUPER_ADMIN);

        expect($superAdmin->canImpersonate())->toBeTrue();
    });

    it('allows users with impersonate permission to impersonate', function () {
        $admin = createUserWithRole(RolesEnum::ADMIN);

        expect($admin->canImpersonate())->toBeTrue();
    });

    it('does not allow editors without impersonate permission to impersonate', function () {
        $editor = createUserWithRole(RolesEnum::EDITOR);

        expect($editor->canImpersonate())->toBeFalse();
    });

    it('does not allow super admins to be impersonated', function () {
        $superAdmin = createUserWithRole(RolesEnum::SUPER_ADMIN);

        expect($superAdmin->canBeImpersonated())->toBeFalse();
    });

    it('allows non-super-admin users to be impersonated', function () {
        $admin = createUserWithRole(RolesEnum::ADMIN);

        expect($admin->canBeImpersonated())->toBeTrue();
    });

    it('persists app authentication secrets', function () {
        $user = User::factory()->create();

        $user->saveAppAuthenticationSecret('test-secret');

        expect($user->fresh()->getAppAuthenticationSecret())->toBe('test-secret');
    });

    it('persists app authentication recovery codes', function () {
        $user  = User::factory()->create();
        $codes = ['code-one', 'code-two'];

        $user->saveAppAuthenticationRecoveryCodes($codes);

        expect($user->fresh()->getAppAuthenticationRecoveryCodes())->toBe($codes);
    });
});
