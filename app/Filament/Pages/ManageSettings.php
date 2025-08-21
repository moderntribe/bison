<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroupsEnum;
use App\Settings\GeneralSettings;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use UnitEnum;

class ManageSettings extends SettingsPage
{
    protected static string $settings = GeneralSettings::class;

    protected static ?string $title = 'Settings';

    protected static ?int $navigationSort = 11;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroupsEnum::ADMIN;

    protected static string|BackedEnum|null $navigationIcon = 'phosphor-sliders';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make(__('General'))
                            ->schema([
                                TextInput::make('site_name')
                                    ->label('Site Name')
                                    ->helperText(__('The name of your site, displayed in the header and footer'))
                                    ->required(),
                                TextInput::make('admin_email')
                                    ->label('Admin Email')
                                    ->helperText(__('The email address for the site administrator, used for notifications and contact'))
                                    ->required(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
