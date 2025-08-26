<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label('')
                    ->grow(false)
                    ->default(fn (User $record): string => $record->getFilamentAvatarUrl())
                    ->circular(),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label(__('Role'))
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->label('Edit User')
                        ->icon('phosphor-pencil')
                        ->url(function (User $record): string {
                            if (Auth::user()->id === $record->id) {
                                return route('filament.dashboard.auth.profile');
                            }

                            return route('filament.dashboard.resources.users.edit', ['record' => $record]);
                        }),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->icon('phosphor-trash'),
                ]),
            ])
            ->striped()
            ->deferLoading()
            ->defaultSort('name')
            ->paginated([25, 50, 100])
            ->defaultPaginationPageOption(25);
    }
}
