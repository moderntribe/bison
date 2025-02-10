<?php

namespace App\Filament\Actions;

use App\Enums\RolesEnum;
use App\Mail\InviteUser;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InviteUserAction
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function action(): Action
    {
        return Action::make('inviteUser')
            ->label(__('Invite User'))
            ->color('gray')
            ->modalIconColor('primary')
            ->modalDescription(__('Manage the access level a user has for your Account by assigning them a Role. Invitations will be sent by email to the user added below.'))
            ->modalIcon('phosphor-user-plus-duotone')
            ->modalWidth('max-w-lg')
            ->form([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->helperText(__('Enter the full name of the user.'))
                    ->required(),
                TextInput::make('email')
                    ->label(__('Email Address'))
                    ->helperText(__('Enter the email address of the user.'))
                    ->unique(table: User::class)
                    ->email()
                    ->required(),
                Select::make('role')
                    ->label(__('Role'))
                    ->helperText(__('Select the role for this user.'))
                    ->options(RolesEnum::class)
                    ->default(RolesEnum::EDITOR->value),
            ])
            ->visible(fn () => auth()->user()?->can('create', User::class))
            ->action(fn (array $data) => $this->handle($data));
    }

    public function handle(array $data): void
    {
        $validator = Validator::make($data, [
            'name'  => 'required',
            'email' => 'required|email|unique:users',
            'role'  => [Rule::enum(RolesEnum::class)],
        ]);

        if ($validator->fails()) {
            Notification::make()
                ->danger()
                ->title(__('Error while inviting user'))
                ->body(__('Please correct the errors below and try again.'))
                ->send();
        }

        // Retrieve the validated input...
        $validated = $validator->validated();

        $user = User::create([
            'name'         => $validated['name'],
            'email'        => $validated['email'],
            'password'     => null,
            'invite_token' => Str::random(60),
        ]);
        $user->assignRole(RolesEnum::from($validated['role']));

        // Send email to the requested user
        Mail::to($user->email)->send(new InviteUser($user));

        // Print a success notification on the screen
        Notification::make()
            ->success()
            ->title(__('Invitation sent'))
            ->body(__('Invitation has been successfully sent to the recipient.'))
            ->send();
    }
}
