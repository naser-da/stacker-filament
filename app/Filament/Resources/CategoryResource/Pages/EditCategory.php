<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->modalHeading(__('filament.resources.categories.delete_modal_title')),
        ];
    }

    public function getTitle(): string
    {
        return __('filament.resources.categories.edit_title');
    }

    public function getBreadcrumbs(): array
    {
        return [
            __('filament.resources.categories.navigation_label'),
            __('filament.resources.categories.edit_breadcrumb'),
        ];
    }
}
