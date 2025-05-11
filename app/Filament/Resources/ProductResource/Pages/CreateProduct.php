<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    public function getTitle(): string
    {
        return __('filament.resources.products.table_heading');
    }

    public function getBreadcrumbs(): array
    {
        return [
            __('filament.resources.products.navigation_label'),
            __('filament.resources.products.create_button'),
        ];
    }
}
