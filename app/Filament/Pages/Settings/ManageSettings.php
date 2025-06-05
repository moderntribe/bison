<?php

namespace App\Filament\Pages\Settings;

use App\Settings\GeneralSettings;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageSettings extends SettingsPage
{
    protected static string $settings = GeneralSettings::class;

    protected static ?string $title = 'Settings';

    protected static ?string $navigationIcon = 'phosphor-gear-six';

    protected static ?int $navigationSort = 11;

    protected static ?string $navigationLabel = 'Settings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
