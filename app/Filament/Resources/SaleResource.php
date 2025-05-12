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

    public static function getNavigationLabel(): string
    {
        return __('filament.resources.sales.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.resources.sales.navigation_group');
    }

    public static function getNavigationBadge(): ?string
    {
        return Sale::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->label(__('filament.resources.sales.customer'))
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label(__('filament.resources.customers.name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label(__('filament.resources.customers.email'))
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label(__('filament.resources.customers.phone'))
                            ->tel()
                            ->maxLength(255),
                    ]),
                Forms\Components\DatePicker::make('order_date')
                    ->label(__('filament.resources.sales.order_date'))
                    ->required()
                    ->default(now())
                    ->displayFormat('d/m/Y'),
                Forms\Components\Repeater::make('products')
                    ->label(__('filament.resources.sales.products'))
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label(__('filament.resources.sales.product'))
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
                            ->label(__('filament.resources.sales.quantity'))
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
                            ->label(__('filament.resources.sales.unit_price'))
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
                    })
                    ->deleteAction(
                        fn (Forms\Components\Actions\Action $action) => $action
                            ->modalHeading(__('filament.resources.sales.delete_product_modal_title'))
                            ->modalDescription(__('filament.resources.sales.delete_product_modal_description'))
                            ->modalSubmitActionLabel(__('filament.common.actions.delete'))
                            ->modalCancelActionLabel(__('filament.common.actions.cancel'))
                    ),
                Forms\Components\TextInput::make('total_amount')
                    ->label(__('filament.resources.sales.total_amount'))
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
                    ->label(__('filament.resources.sales.notes'))
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->label(__('filament.resources.sales.customer'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->label(__('filament.resources.sales.order_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->money()
                    ->label(__('filament.resources.sales.total_amount'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('products_count')
                    ->counts('products')
                    ->label(__('filament.resources.sales.items'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label(__('filament.resources.sales.created_at'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label(__('filament.resources.sales.updated_at'))
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
                Tables\Actions\DeleteAction::make()
                    ->modalHeading(__('filament.resources.sales.delete_modal_title')),
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
