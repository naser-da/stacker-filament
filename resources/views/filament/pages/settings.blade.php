<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="mt-4">
            <x-filament::button type="submit">
                {{ __('filament.common.actions.save') }}
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page> 