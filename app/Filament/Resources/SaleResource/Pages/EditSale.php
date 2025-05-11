<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditSale extends EditRecord
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->modalHeading(__('filament.resources.sales.delete_modal_title')),
        ];
    }

    public function getTitle(): string
    {
        return __('filament.resources.sales.edit_title');
    }

    public function getBreadcrumbs(): array
    {
        return [
            __('filament.resources.sales.navigation_label'),
            __('filament.resources.sales.edit_breadcrumb'),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['products'] = $this->record->products->map(function ($product) {
            return [
                'product_id' => $product->id,
                'quantity' => $product->pivot->quantity,
                'unit_price' => $product->pivot->unit_price,
            ];
        })->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $total = 0;
        
        if (isset($data['products'])) {
            foreach ($data['products'] as $product) {
                $total += $product['quantity'] * $product['unit_price'];
            }
        }

        $data['total_amount'] = $total;

        return $data;
    }

    protected function afterSave(): void
    {
        // Sync products with their quantities and prices
        if (isset($this->data['products'])) {
            $products = collect($this->data['products'])->mapWithKeys(function ($item) {
                return [$item['product_id'] => [
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]];
            })->all();

            $this->record->products()->sync($products);
        }
    }
}
