<x-filament-panels::page class="fi-dashboard-page">
    @if (method_exists($this, 'filtersForm'))
        {{ $this->filtersForm }}
    @endif

    <section class="grid grid-flow-col grid-cols-4 gap-6">
        <div class="col-span-full md:col-span-1">
            <div class="grid gap-4">
                <x-filament-widgets::widgets
                    :columns="1"
                    :data="$this->getSidebarWidgets()"
                    :widgets="$this->getSidebarWidgets()"
                />
            </div>
        </div>
        <div class="col-span-full md:col-span-3">
            <x-filament-widgets::widgets
                :columns="$this->getColumns()"
                :data="
                [
                    ...(property_exists($this, 'filters') ? ['filters' => $this->filters] : []),
                    ...$this->getWidgetData(),
                ]
            "
                :widgets="$this->getVisibleWidgets()"
            />
        </div>
    </section>
</x-filament-panels::page>
