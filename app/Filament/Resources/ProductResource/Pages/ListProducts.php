<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    public function getTitle(): string
    {
        return __('filament.resources.products.table_heading');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('filament.resources.products.create_button')),
        ];
    }

    public function getBreadcrumbs(): array
    {
        return [
            __('filament.resources.products.navigation_label'),
        ];
    }
}
