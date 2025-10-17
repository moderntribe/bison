<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use STS\FilamentImpersonate\Actions\Impersonate;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                DeleteAction::make(),
                Impersonate::make()
                    ->record($this->getRecord())
                    ->label(__('Impersonate User'))
                    ->icon('phosphor-detective')
                    ->redirectTo(route('filament.dashboard.pages.dashboard'))
                    ->color('gray'),
            ])
                ->button()
                ->label(__('Actions'))
                ->color('gray'),
        ];
    }
}
