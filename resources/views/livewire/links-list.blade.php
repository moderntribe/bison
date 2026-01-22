<x-filament-widgets::widget>
    @if($title)
        <h2 class="font-semibold leading-6 text-gray-950 dark:text-white mb-4">
            {{ $title }}
        </h2>
    @endif
    <ol>
        @foreach ($links as $link )
            <li class="mb-2 mr-2 inline-block md:block md:mr-0">
                @if ($buttons)
                    <x-filament::button
                        href="{{ $link['url'] ?? '#' }}"
                        tag="a"
                        color="gray"
                        icon="{{ $link['icon'] ?? false }}"
                        target="{{ $link['target'] ?? '_self' }}"
                    >
                        {{ $link['label'] ?? '' }}
                    </x-filament::button>
                @else
                    <x-filament::link
                        href="{{ $link['url'] ?? '#' }}"
                        tag="a"
                        color="gray"
                        icon="{{ $link['icon'] ?? false }}"
                        target="{{ $link['target'] ?? '_self' }}"
                    >
                        {{ $link['label'] ?? '' }}
                    </x-filament::link>
                @endif
            </li>
        @endforeach
    </ol>
</x-filament-widgets::widget>
