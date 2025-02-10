<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Actions\InviteUserAction;
use App\Filament\Resources\UserResource;
use App\Livewire\RichTextWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('Add User')),
            InviteUserAction::make()
                ->action(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            RichTextWidget::make([
                'content' => 'Users who have access to this Application. Only an Admin can invite users and assign user roles.',
                'lazy'    => false, // disable Lazy load of the widget content
            ]),
        ];
    }
}
