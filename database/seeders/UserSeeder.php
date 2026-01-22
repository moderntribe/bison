<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(250)
            ->create()
            ->each(function (
                User $user
            ) {
                // Assign a random role to the user
                $user->assignRole(array_rand([RolesEnum::EDITOR->value, RolesEnum::ADMIN->value]));
            });
    }
}
