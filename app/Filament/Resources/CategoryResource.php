<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\EditAction;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Inventory Management';

    public static function getNavigationLabel(): string
    {
        return __('filament.resources.categories.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament.resources.categories.navigation_group');
    }

    public static function getNavigationBadge(): ?string
    {
        return Category::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->label(__('filament.resources.categories.name'))
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('description')
                    ->label(__('filament.resources.categories.description'))
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.resources.categories.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('filament.resources.categories.description'))
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('products_count')
                    ->label(__('filament.resources.categories.products_count'))
                    ->counts('products')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('filament.resources.categories.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('filament.resources.categories.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([

                EditAction::make()->modalHeading(__('filament.resources.categories.edit_title')),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
        ];
    }
}
