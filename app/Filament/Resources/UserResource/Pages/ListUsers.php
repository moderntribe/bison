<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Mail\InviteUser;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('Add User')),
            Action::make('inviteUser')
                ->label(__('Invite User'))
                ->color('gray')
                ->modalIconColor('primary')
                ->modalDescription(__('Enter the user details to send an invite.'))
                ->modalIcon('phosphor-user-plus-duotone')
                ->modalWidth('max-w-lg')
                ->form([
                    TextInput::make('name')
                        ->label(__('Name'))
                        ->required(),
                    TextInput::make('email')
                        ->label(__('Email Address'))
                        ->unique(table: User::class)
                        ->email()
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $inviteToken = Str::random(60);
                    $user        = User::create([
                        'name'         => $data['name'],
                        'email'        => $data['email'],
                        'password'     => null,
                        'invite_token' => $inviteToken,
                    ]);

                    Mail::to($user->email)->send(new InviteUser($user));
                    Notification::make()
                        ->success()
                        ->title('Invitation sent')
                        ->body('Invitation has been successfully sent to the recipient.')
                        ->send();
                }),
        ];
    }
}
