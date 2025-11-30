<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Forms\ProductDetailsForm;
use App\Filament\Admin\Forms\ProductMediaForm;
use App\Filament\Admin\Resources\InventoryResource\RelationManagers\InventoryRelationManager;
use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Filament\Admin\Resources\ProductResource\RelationManagers\FrequentlyBoughtTogetherRelationManager;
use App\Filament\Admin\Resources\ProductResource\RelationManagers\ImagesRelationManager;
use App\Filament\Admin\Resources\ProductResource\RelationManagers\ProductOptionsRelationManager;
use App\Filament\Admin\Resources\ProductResource\RelationManagers\VariantsRelationManager;
use App\Models\Product;
use App\Services\Admin\Form\Fields\Input;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Product Tabs')
                    ->tabs([
                        Tab::make('Product Details')
                            ->schema(ProductDetailsForm::getComponents()),
                        Tab::make('Product Images & Files')
                            ->schema(ProductMediaForm::getComponents()),
                    ])
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('translations.name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('brand.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stock.quantity')
                    ->label('In stock (pcs)')
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            InventoryRelationManager::class,
            FrequentlyBoughtTogetherRelationManager::class,
            ProductOptionsRelationManager::class,
            VariantsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
