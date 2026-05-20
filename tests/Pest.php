<?php

use App\Enums\RolesEnum;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;

pest()->extend(Tests\TestCase::class)
    ->in('Unit');

pest()->extend(Tests\TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
*/

function seedRolesAndPermissions(): void
{
    test()->seed(RolesAndPermissionsSeeder::class);
}

function createUserWithRole(RolesEnum $role, array $attributes = []): User
{
    seedRolesAndPermissions();

    $user = User::factory()->create($attributes);

    $user->assignRole($role);

    return $user;
}

function actingAsFilamentUser(User $user): User
{
    test()->actingAs($user);

    Filament::setCurrentPanel(Filament::getPanel('dashboard'));

    return $user;
}
