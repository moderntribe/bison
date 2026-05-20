<?php

namespace App\Console\Commands;

use App\Enums\RolesEnum;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class CreateUser extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'app:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user with specific details and assigned role';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name  = text(label: 'What is the name of the user?', required: true);
        $email = text(
            label: 'What is the email of the user?',
            required: true,
            validate: ['email' => 'required|unique:users']
        );
        $password = password(
            label: 'What is the password of the user?',
            required: true,
            validate: ['password' => 'min:8']
        );
        $role = select(
            label: 'What is the role of the user?',
            options: collect(RolesEnum::cases())
                ->flatMap(function ($role) {
                    return [
                        $role->value => $role->getLabel(),
                    ];
                })
                ->toArray()
        );

        try {
            // Create user without firing events
            // this will be a "silent" creation to prevent our default role assignment from triggering
            $user = User::withoutEvents(function () use ($name, $email, $password, $role) {
                $role = Role::where('name', $role)->firstOrFail();

                return tap(
                    User::create([
                        'name'     => $name,
                        'email'    => $email,
                        'password' => Hash::make($password),
                    ])
                )
                    ->assignRole($role);
            });
        } catch (Exception $e) {
            $this->error("Failed to create user: {$e->getMessage()}");

            return Command::FAILURE;
        }

        $this->info("User: {$user->name} with role {$role} created successfully.");

        return Command::SUCCESS;
    }
}
