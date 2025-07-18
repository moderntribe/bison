<?php

namespace App\Filament\Pages\Auth;

use App\Filament\Resources\Users\UserResource;
use App\Models\Role;
use Filament\Auth\Pages\EditProfile as EditProfileBase;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class EditProfile extends EditProfileBase
{
    public static function getLabel(): string
    {
        return __('Edit Profile');
    }

    public function getTitle(): string|Htmlable
    {
        return self::getLabel();
    }

    public function getBreadcrumbs(): array
    {
        return [
            UserResource::getBreadcrumb(),
            $this->getTitle(),
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make(__('Account Details'))
                            ->schema([
                                $this->getNameFormComponent()
                                    ->helperText(__('Your full name, used for display purposes')),
                                $this->getEmailFormComponent()
                                    ->helperText(__('Your email address, used for notifications and account recovery'))
                                    ->prefixIcon('phosphor-envelope-simple'),
                                Select::make('roles')
                                    ->label(__('Role'))
                                    ->relationship('roles', 'name')
                                    ->getOptionLabelFromRecordUsing(fn (Role $record) => $record?->name?->getLabel())
                                    ->prefixIcon('phosphor-shield-check')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                            ]),
                        Tab::make(__('Security'))
                            ->schema([
                                $this->getPasswordFormComponent()
                                    ->label(__('New Password')),
                                $this->getPasswordConfirmationFormComponent()
                                    ->label(__('Confirm New Password'))
                                    ->helperText(__('Verify your new password')),
                                $this->getCurrentPasswordFormComponent(),
                            ]),
                    ])
                    ->inlineLabel(false)
                    ->persistTabInQueryString(),
            ]);
    }
}
