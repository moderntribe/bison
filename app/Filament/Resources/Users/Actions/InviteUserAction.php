<?php

namespace App\Filament\Resources\Users\Actions;

use App\Enums\RolesEnum;
use App\Mail\InviteUser;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Size;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InviteUserAction
{
    public static function make(string $name): Action
    {
        return Action::make($name)
            ->label(__('Invite User'))
            ->icon('phosphor-envelope-simple')
            ->size(Size::Small)
            ->color('gray')
            ->modalIconColor(Color::Blue)
            ->modalDescription(__('Manage the access level a user has for your Account by assigning them a Role. Invitations will be sent by email to the user added below.'))
            ->modalIcon('phosphor-user-plus-duotone')
            ->modalWidth(Width::ExtraLarge)
            ->tooltip(__('Invite a new user to your account'))
            ->schema([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->helperText(__('Enter the full name of the user.'))
                    ->maxLength(255)
                    ->required(),
                TextInput::make('email')
                    ->label(__('Email Address'))
                    ->helperText(__('Enter the email address of the user.'))
                    ->prefixIcon('phosphor-envelope-simple')
                    ->unique()
                    ->validationMessages([
                        'unique' => 'This :attribute has already been registered.',
                    ])
                    ->email()
                    ->maxLength(255)
                    ->required(),
                Select::make('role')
                    ->label(__('Role'))
                    ->helperText(__('Select the role for this user.'))
                    ->prefixIcon('phosphor-shield-check')
                    ->options(RolesEnum::class)
                    ->default(RolesEnum::EDITOR->value)
                    ->required(),
            ])
            ->action(fn (array $data) => InviteUserAction::handle($data));
    }

    public static function handle(array $data): void
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

        // Create user without firing events
        // this will be a "silent" creation to prevent our default role assignment from triggering
        $user = User::withoutEvents(function () use ($validated) {
            return tap(
                User::create([
                    'name'         => $validated['name'],
                    'email'        => $validated['email'],
                    'password'     => null,
                    'invite_token' => Str::random(60),
                ])
            )
                ->assignRole($validated['role']);
        });

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
