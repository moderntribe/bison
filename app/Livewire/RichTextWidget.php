<?php

namespace App\Livewire;

use Filament\Widgets\Widget;

class RichTextWidget extends Widget
{
    public string $content;
    protected string $view = 'livewire.rich-text-widget';

    protected int|string|array $columnSpan = 2;
}
