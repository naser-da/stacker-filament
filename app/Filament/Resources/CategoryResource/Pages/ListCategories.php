<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('filament.resources.categories.create_button')),
        ];
    }

    public function getTitle(): string
    {
        return __('filament.resources.categories.table_heading');
    }

    public function getBreadcrumbs(): array
    {
        return [
            __('filament.resources.categories.navigation_label'),
        ];
    }


}
