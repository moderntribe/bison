<?php

namespace App\Filament\Pages\Auth;

use App\Filament\Resources\Users\UserResource;
use App\Models\Role;
use Filament\Auth\Pages\EditProfile as EditProfileBase;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
        /** @var TextInput $nameFormComponent */
        $nameFormComponent = $this->getNameFormComponent();

        /** @var TextInput $emailFormComponent */
        $emailFormComponent = $this->getEmailFormComponent();

        /** @var TextInput $passwordFormComponent */
        $passwordFormComponent = $this->getPasswordFormComponent();

        /** @var TextInput $passwordConfirmationFormComponent */
        $passwordConfirmationFormComponent = $this->getPasswordConfirmationFormComponent();

        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make(__('Account Details'))
                            ->schema([
                                $nameFormComponent
                                    ->helperText(__('Your full name, used for display purposes')),
                                $emailFormComponent
                                    ->helperText(__('Your email address, used for notifications and account recovery'))
                                    ->prefixIcon('phosphor-envelope-simple'),
                                Select::make('roles')
                                    ->label(__('Role'))
                                    ->relationship('roles', 'name')
                                    ->getOptionLabelFromRecordUsing(fn (Role $record): string => $record->name->getLabel())
                                    ->prefixIcon('phosphor-shield-check')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                            ]),
                        Tab::make(__('Security'))
                            ->schema([
                                $passwordFormComponent
                                    ->label(__('New Password')),
                                $passwordConfirmationFormComponent
                                    ->label(__('Confirm New Password'))
                                    ->helperText(__('Verify your new password')),
                                $this->getCurrentPasswordFormComponent(),
                                $this->getMultiFactorAuthenticationContentComponent(),
                            ]),
                    ])
                    ->inlineLabel(false)
                    ->persistTabInQueryString(),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getFormContentComponent(),
            ]);
    }
}
