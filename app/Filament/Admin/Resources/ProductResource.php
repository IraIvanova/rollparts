<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Filament\Admin\Resources\ProductResource\RelationManagers;
use App\Filament\Admin\Resources\ProductResource\RelationManagers\PricesRelationManager;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Product Tabs')
                    ->tabs([
                        Tab::make('Product Details')
                            ->schema([
                                Repeater::make('translations')
                                    ->label('Translations')
                                    ->relationship('translations')
                                    ->schema([
                                        Select::make('language')
                                            ->label('Language')
                                            ->options(
                                                Language::all()->pluck('name', 'code')
                                            )
                                            ->default('Turkish')
                                            ->required()

                                            ->searchable(),
//                                                    ->extraAttributes(['style' => 'width: 150px;']), // Fixed width
                                        TextInput::make('name')
                                            ->label('Name')
                                            ->required()
                                            ->maxLength(255),
                                        // Force grid alignment
                                        MarkdownEditor::make('description')
                                            ->label('Description')
                                            ->columnSpanFull()
                                            ->nullable(),
                                    ])
                                    ->addActionLabel('Add translation')
                                    ->collapsible(),
                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->rules(['alpha_dash'])
                                    ->unique(),
                                Select::make('brand_id')
                                    ->relationship('brand', 'name')
                                    ->searchable(['name'])
                                    ->required(),
                                Select::make('category_id')
                                    ->relationship('categories', 'name')
                                    ->multiple()
                                    ->searchable(),
                                Repeater::make('prices')
                                    ->label('Product Prices')
                                    ->relationship('prices')
                                    ->schema([
                                        TextInput::make('price')
                                            ->label('Price')
                                            ->numeric()
                                            ->required(),
                                        Select::make('currency_id')
                                            ->label('Currency')
                                            ->options(Currency::pluck('code', 'id'))
                                            ->required(),
//                                                            ->rules(['unique:prices,currency,NULL,id,product_id,' . request()->route('record')]), // Prevent duplicate currencies

                                        TextInput::make('discount_amount')
                                            ->label('Discount (%)')
                                            ->numeric()
                                            ->reactive()
                                            ->suffix('%')
                                            ->afterStateUpdated(
                                                function ($state, callable $get, callable $set) {
                                                    $price = $get('price');
                                                    if ($price && $state !== null) {
                                                        $discountedPrice = $price - ($price * $state / 100);
                                                        $set(
                                                            'discounted_price',
                                                            round($discountedPrice, 2)
                                                        );
                                                    }
                                                }
                                            ),

                                        // Discounted price field
                                        TextInput::make('discounted_price')
                                            ->label('Price with Discount')
                                            ->numeric()
                                            ->reactive()
                                            ->afterStateUpdated(
                                                function ($state, callable $get, callable $set) {
                                                    $price = $get('price');
                                                    if ($price && $state !== null) {
                                                        $discountPercent = (($price - $state) / $price) * 100;
                                                        $set(
                                                            'discount_percent',
                                                            round($discountPercent, 2)
                                                        );
                                                    }
                                                }
                                            ),

                                    ])
                                    ->defaultItems(1)
                                    ->minItems(1)
                                    ->maxItems(10)
                                    ->addActionLabel('Add price')
                                    ->columns(2)
                                    ->columnSpanFull()
                            ]),

                        Tab::make('Product Images & Files')
                            ->schema([
                                FileUpload::make('Product images')
                                    ->multiple()
                                    ->reorderable()
                                    ->appendFiles()
                                    ->imagePreviewHeight('250')
                                    ->image(),
                                FileUpload::make('Product documents')
                                    ->multiple()
                            ]),
                    ])
                    ->columnSpanFull()
//                    ])
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
                TextColumn::make('quantity')
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
            PricesRelationManager::class
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
