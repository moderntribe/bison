<?php

namespace App\Livewire;

use Filament\Widgets\Widget;

class RichTextWidget extends Widget
{
    protected static string $view = 'livewire.rich-text-widget';

    public string $content;

    protected int|string|array $columnSpan = 2;
}
