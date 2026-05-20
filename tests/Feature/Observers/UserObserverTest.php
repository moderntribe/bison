<?php

use App\Enums\RolesEnum;
use App\Models\User;

describe('UserObserver', function () {
    beforeEach(function () {
        seedRolesAndPermissions();
    });

    it('assigns the editor role when a user is created without a role', function () {
        $user = User::factory()->create();

        expect($user->hasRole(RolesEnum::EDITOR))->toBeTrue();
    });

    it('does not assign the editor role when the user already has a role', function () {
        $user = User::withoutEvents(function () {
            $user = User::factory()->create();
            $user->assignRole(RolesEnum::ADMIN);

            return $user;
        });

        (new \App\Observers\UserObserver)->created($user);

        expect($user->hasRole(RolesEnum::ADMIN))->toBeTrue()
            ->and($user->hasRole(RolesEnum::EDITOR))->toBeFalse();
    });
});
