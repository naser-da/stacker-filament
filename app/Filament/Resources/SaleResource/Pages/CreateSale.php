<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateSale extends CreateRecord
{
    protected static string $resource = SaleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
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

    protected function afterCreate(): void
    {
        // Attach products with their quantities and prices
        if (isset($this->data['products'])) {
            $products = collect($this->data['products'])->mapWithKeys(function ($item) {
                return [$item['product_id'] => [
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]];
            })->all();

            $this->record->products()->attach($products);
        }
    }
}
