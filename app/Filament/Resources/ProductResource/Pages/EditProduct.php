<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->modalHeading(__('filament.resources.products.delete_modal_title'))
                ->modalDescription(__('filament.resources.products.delete_modal_description')),
        ];
    }

    public function getTitle(): string
    {
        return __('filament.resources.products.edit_title');
    }

    public function getBreadcrumbs(): array
    {
        return [
            __('filament.resources.products.navigation_label'),
            __('filament.resources.products.edit_breadcrumb'),
        ];
    }
}
