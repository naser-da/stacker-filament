<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewSale extends ViewRecord
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Sale Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('customer.name')
                            ->label('Customer'),
                        Infolists\Components\TextEntry::make('total_amount')
                            ->money(),
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('notes')
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make('Products')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('products')
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Product'),
                                Infolists\Components\TextEntry::make('pivot.quantity')
                                    ->label('Quantity'),
                                Infolists\Components\TextEntry::make('pivot.unit_price')
                                    ->money()
                                    ->label('Unit Price'),
                                Infolists\Components\TextEntry::make('subtotal')
                                    ->state(function ($record) {
                                        return $record->pivot->quantity * $record->pivot->unit_price;
                                    })
                                    ->money()
                                    ->label('Subtotal'),
                            ])
                            ->columns(4),
                    ]),
            ]);
    }
} 