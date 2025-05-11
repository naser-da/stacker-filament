<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSales extends ListRecords
{
    protected static string $resource = SaleResource::class;

    public function getTitle(): string
    {
        return __('filament.resources.sales.table_heading');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('filament.resources.sales.create_button')),
        ];
    }

    public function getBreadcrumbs(): array
    {
        return [
            __('filament.resources.sales.navigation_label'),
        ];
    }
}
