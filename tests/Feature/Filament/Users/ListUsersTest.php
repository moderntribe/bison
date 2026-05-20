<?php

use App\Enums\RolesEnum;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\User;
use Livewire\Livewire;

describe('ListUsers', function () {
    it('allows an admin to view the users table', function () {
        $admin = createUserWithRole(RolesEnum::ADMIN);
        $users = User::factory()->count(2)->create();

        actingAsFilamentUser($admin);

        Livewire::test(ListUsers::class)
            ->assertSuccessful()
            ->loadTable()
            ->assertCanSeeTableRecords($users);
    });

    it('can search users by name', function () {
        $admin        = createUserWithRole(RolesEnum::ADMIN);
        $matchingUser = User::factory()->create(['name' => 'Unique Search Name']);
        $otherUser    = User::factory()->create(['name' => 'Someone Else']);

        actingAsFilamentUser($admin);

        Livewire::test(ListUsers::class)
            ->loadTable()
            ->searchTable('Unique Search Name')
            ->assertCanSeeTableRecords([$matchingUser])
            ->assertCanNotSeeTableRecords([$otherUser]);
    });
});
