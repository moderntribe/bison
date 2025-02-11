<?php

namespace App\Filament\Pages;

use App\Livewire\LinksList;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard as DashboardPage;
use Filament\Widgets\AccountWidget;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends DashboardPage
{
    protected static ?string $navigationIcon = 'phosphor-circles-three-plus-duotone';

    protected static string $view = 'filament.pages.dashboard';

    public function getColumns(): int|string|array
    {
        return [
            'default' => 1,
            'xl'      => 2,
        ];
    }

    public function getHeading(): string|Htmlable
    {
        return sprintf('Welcome, %s', Filament::getUserName(auth()->user()));
    }

    public function getSubheading(): string
    {
        return date('l, F jS');
    }

    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
        ];
    }

    public function getSidebarWidgets(): array
    {
        return [
            LinksList::make([
                'lazy'  => false,
                'title' => __('Quick Actions'),
                'links' => [
                    [
                        'label' => 'Homepage',
                        'url'   => config('app.url'),
                        'icon'  => 'phosphor-house',
                    ],
                    [
                        'label' => 'Edit Profile',
                        'url'   => route('filament.dashboard.auth.profile'),
                        'icon'  => 'phosphor-pencil-simple',
                    ],
                    [
                        'label' => 'Add User',
                        'url'   => route('filament.dashboard.resources.users.create'),
                        'icon'  => 'phosphor-user-plus',
                    ],
                ],
            ]),
            LinksList::make([
                'lazy'    => false,
                'buttons' => false,
                'title'   => __('Support'),
                'links'   => [
                    [
                        'label'  => 'Documentation',
                        'url'    => 'https://github.com/moderntribe/bison/wiki',
                        'icon'   => 'phosphor-book-bookmark-duotone',
                        'target' => '_blank',
                    ],
                    [
                        'label'  => 'Github',
                        'url'    => 'https://github.com/moderntribe/bison',
                        'icon'   => 'phosphor-github-logo-duotone',
                        'target' => '_blank',
                    ],
                    [
                        'label'  => 'Notion',
                        'url'    => 'https://www.notion.so/stellarwp/1c8d740aae2d407baa05fd2482e04247?v=79a64e0555d74bbda9e021c6017c5380&pvs=4',
                        'icon'   => 'phosphor-notion-logo-duotone',
                        'target' => '_blank',
                    ],
                ],
            ]),
        ];
    }
}
