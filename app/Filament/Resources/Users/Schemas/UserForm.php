<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Role;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('User Information'))
                    ->description(__('Create or Update the user by filling out the following information.'))
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('phosphor-envelope-simple')
                            ->unique()
                            ->validationMessages([
                                'unique' => 'This :attribute has already been registered.',
                            ]),
                        Select::make('roles')
                            ->label(__('Role'))
                            ->relationship('roles', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Role $record) => $record?->name?->getLabel())
                            ->prefixIcon('phosphor-shield-check')
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('password')
                            ->label(__('New Password'))
                            ->validationAttribute(__('filament-panels::auth/pages/edit-profile.form.password.validation_attribute'))
                            ->password()
                            ->revealable(filament()->arePasswordsRevealable())
                            ->rule(Password::default())
                            ->showAllValidationMessages()
                            ->autocomplete('new-password')
                            ->dehydrated(fn ($state): bool => filled($state))
                            ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                            ->live(debounce: 500)
                            ->same('passwordConfirmation'),
                        TextInput::make('passwordConfirmation')
                            ->label(__('Confirm New Password'))
                            ->validationAttribute(__('filament-panels::auth/pages/edit-profile.form.password_confirmation.validation_attribute'))
                            ->password()
                            ->revealable(filament()->arePasswordsRevealable())
                            ->required()
                            ->visible(fn (Get $get): bool => filled($get('password')))
                            ->dehydrated(false),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
