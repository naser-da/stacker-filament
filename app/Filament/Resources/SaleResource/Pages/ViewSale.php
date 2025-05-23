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

    public function getTitle(): string
    {
        return __('filament.resources.sales.view_title');
    }

    public function getBreadcrumbs(): array
    {
        return [
            __('filament.resources.sales.navigation_label'),
            __('filament.resources.sales.view_breadcrumb'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make(__('filament.resources.sales.sale_information'))
                    ->schema([
                        Infolists\Components\TextEntry::make('id')
                            ->label(__('filament.resources.sales.id'))
                            ->numeric()
                            ->formatStateUsing(fn ($state) => number_format($state, 0, '.', '')),
                        Infolists\Components\TextEntry::make('customer.name')
                            ->label(__('filament.resources.sales.customer')),
                        Infolists\Components\TextEntry::make('order_date')
                            ->label(__('filament.resources.sales.order_date'))
                            ->date('d/m/Y'),
                        Infolists\Components\TextEntry::make('total_amount')
                            ->money('USD', 3)
                            ->label(__('filament.resources.sales.total_amount'))
                            ->formatStateUsing(fn ($state) => '$' . number_format($state, 3, '.', ''))
                        ,
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime('d/m/Y H:i')
                            ->label(__('filament.resources.sales.created_at')),
                        Infolists\Components\TextEntry::make('notes')
                            ->label(__('filament.resources.sales.notes')),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make(__('filament.resources.sales.products'))
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('products')
                            ->label(' ')
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label(__('filament.resources.sales.product')),
                                Infolists\Components\TextEntry::make('pivot.quantity')
                                    ->label(__('filament.resources.sales.quantity')),
                                Infolists\Components\TextEntry::make('pivot.unit_price')
                                    ->money('USD', 3)
                                    ->label(__('filament.resources.sales.unit_price'))
                                    ->formatStateUsing(fn ($state) => '$' . number_format($state, 3, '.', ''))
                                ,
                                Infolists\Components\TextEntry::make('subtotal')
                                    ->state(function ($record) {
                                        return $record->pivot->quantity * $record->pivot->unit_price;
                                    })
                                    ->money('USD', 3)
                                    ->label(__('filament.resources.sales.subtotal'))
                                    ->formatStateUsing(fn ($state) => '$' . number_format($state, 3, '.', ''))
                                ,
                            ])
                            ->columns(4),
                    ]),
            ]);
    }
} 