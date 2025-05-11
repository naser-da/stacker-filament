<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Sales Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                    ]),
                Forms\Components\Repeater::make('products')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('Product')
                            ->options(\App\Models\Product::pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $set('unit_price', \App\Models\Product::find($state)?->price ?? 0);
                                $set('total_amount', self::calculateTotal($get('products')));
                            }),
                        Forms\Components\TextInput::make('quantity')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->minValue(0)
                            ->step(1)
                            ->live(debounce: 1000)
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $set('total_amount', self::calculateTotal($get('products')));
                            }),
                        Forms\Components\TextInput::make('unit_price')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->step(0.01)
                            ->prefix('$')
                            ->live(debounce: 1000)
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $set('total_amount', self::calculateTotal($get('products')));
                            }),
                    ])
                    ->columns(3)
                    ->columnSpanFull()
                    ->defaultItems(0)
                    ->reorderable(false)
                    ->itemLabel(fn (array $state): ?string => isset($state['product_id']) ? \App\Models\Product::find($state['product_id'])?->name : null)
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('total_amount', self::calculateTotal($state));
                    }),
                Forms\Components\TextInput::make('total_amount')
                    ->label('Total Amount')
                    ->prefix('$')
                    ->disabled()
                    ->dehydrated()
                    ->afterStateHydrated(function ($component, $state, $record) {
                        if ($record) {
                            $total = $record->products->sum(function ($product) {
                                return $product->pivot->quantity * $product->pivot->unit_price;
                            });
                            $component->state($total);
                        }
                    }),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Items')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('customer')
                    ->relationship('customer', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'view' => Pages\ViewSale::route('/{record}'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }

    protected static function calculateTotal($products): float
    {
        if (!is_array($products)) {
            return 0;
        }

        return collect($products)->sum(function ($product) {
            if (!isset($product['quantity']) || !isset($product['unit_price'])) {
                return 0;
            }

            $quantity = filter_var($product['quantity'], FILTER_VALIDATE_FLOAT);
            $unitPrice = filter_var($product['unit_price'], FILTER_VALIDATE_FLOAT);

            if ($quantity === false || $unitPrice === false) {
                return 0;
            }

            return $quantity * $unitPrice;
        });
    }
}
