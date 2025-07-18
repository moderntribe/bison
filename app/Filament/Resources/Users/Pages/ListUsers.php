<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\Actions\InviteUserAction;
use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Size;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('Create User'))
                ->icon('phosphor-user-plus')
                ->size(Size::Small)
                ->tooltip(__('Create a new user')),
            InviteUserAction::make('invite-user'),
        ];
    }
}
