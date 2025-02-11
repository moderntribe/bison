<?php

namespace App\Livewire;

use Filament\Widgets\Widget;

class LinksList extends Widget
{
    protected static string $view = 'livewire.links-list';

    public bool $buttons = true;

    public string $title = 'Links';

    public array $links = [
        [
            'label' => 'Filament',
            'url'   => 'https://filamentphp.com',
        ],
        [
            'label' => 'GitHub',
            'url'   => 'https://github.com/',
            'icon'  => 'phosphor-github-logo-duotone',
        ],
    ];
}
