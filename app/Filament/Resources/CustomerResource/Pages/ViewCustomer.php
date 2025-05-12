<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\RepeatableEntry;

class ViewCustomer extends ViewRecord
{
    protected static string $resource = CustomerResource::class;

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
                Infolists\Components\Section::make(__('filament.resources.customers.customer_information'))
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label(__('filament.resources.customers.name')),
                        Infolists\Components\TextEntry::make('email')
                            ->label(__('filament.resources.customers.email')),
                        Infolists\Components\TextEntry::make('phone')
                            ->label(__('filament.resources.customers.phone')),
                        Infolists\Components\TextEntry::make('address')
                            ->label(__('filament.resources.customers.address')),
                        Infolists\Components\TextEntry::make('notes')
                            ->label(__('filament.resources.customers.notes')),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make(__('filament.resources.customers.sales_information'))
                    ->schema([
                        Infolists\Components\TextEntry::make('total_orders_amount')
                            ->label(__('filament.resources.customers.total_orders_amount'))
                            ->money('USD', 3)
                            ->state(fn ($record) => $record->getTotalOrdersAmount())
                            ->formatStateUsing(fn ($state) => '$' . number_format($state, 3, '.', ''))
                            ->money('USD', 3)
                            ->state(fn ($record) => $record->getTotalOrdersAmount())
                            ->formatStateUsing(fn ($state) => '$' . number_format($state, 3, '.', '')),
                        Infolists\Components\TextEntry::make('last_order_date')
                            ->label(__('filament.resources.customers.last_order_date'))
                            ->date('d/m/Y')
                            ->state(fn ($record) => $record->getLastOrderDate()),
                        Infolists\Components\TextEntry::make('total_orders')
                            ->label(__('filament.resources.customers.total_orders'))
                            ->state(fn ($record) => $record->sales()->count()),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make(__('filament.resources.customers.recent_sales'))
                    ->schema([
                        Infolists\Components\TextEntry::make('no_sales')
                            ->label(__('filament.resources.customers.no_sales'))
                            ->visible(fn ($record) => $record->sales()->count() === 0),
                        Infolists\Components\RepeatableEntry::make('sales')
                            ->schema([
                                Infolists\Components\TextEntry::make('id')
                                    ->label(__('filament.resources.sales.id'))
                                    ->numeric()
                                    ->formatStateUsing(fn ($state) => number_format($state, 0, '.', '')),
                                Infolists\Components\TextEntry::make('order_date')
                                    ->label(__('filament.resources.sales.order_date'))
                                    ->date('d/m/Y'),
                                Infolists\Components\TextEntry::make('total_amount')
                                    ->label(__('filament.resources.sales.total_amount'))
                                    ->money('USD', 3)
                                    ->formatStateUsing(fn ($state) => '$' . number_format($state, 3, '.', ''))
                                    ->money('USD', 3)
                                    ->formatStateUsing(fn ($state) => '$' . number_format($state, 3, '.', '')),
                            ])
                            ->columns(3)
                            ->state(fn ($record) => $record->sales()->latest()->take(5)->get())
                            ->visible(fn ($record) => $record->sales()->count() > 0),
                    ]),
            ]);
    }
} 