<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Models\Currency;
use App\Models\Language;
use App\Models\OptionValue;
use App\Models\Product;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

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
                                        TextInput::make('name')
                                            ->label('Name')
                                            ->required()
                                            ->maxLength(255),
                                        // Force grid alignment
                                        RichEditor::make('description')
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
                                    ->disabledOn('edit')
                                    ->unique('products', 'slug', ignoreRecord: true),
                                TextInput::make('mnf_code')
                                    ->maxLength(255),
                                Select::make('brand_id')
                                    ->relationship('brand', 'name')
                                    ->searchable(['name'])
                                    ->required(),
                                SelectTree::make('categories')
                                    ->relationship('categories', 'name', 'parent_id')
                                    ->enableBranchNode()
                                    ->searchable(),
                                TextInput::make('quantity')
                                    ->numeric()
                                    ->label('Quantity (Main Product)')
                                    ->required(),
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
                        Tab::make('Product Options')
                            ->schema([
                                Repeater::make('optionValues')
                                    ->label('Product Options')
                                    ->relationship('optionValues')
                                    ->schema([
                                        Select::make('option_id')
                                            ->label('Option')
                                            ->relationship('option', 'name')
                                            ->live()
                                            ->required(),
                                        Select::make('value')
                                            ->label('Value')
                                            ->options(fn(Get $get): Collection => OptionValue::query()
                                                ->where('option_id', $get('option_id'))
                                                ->pluck('value', 'id'))
                                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                            ->required(),
                                        TextInput::make('quantity')
                                            ->required(),
                                        TextInput::make('price'),
                                    ])
                                    ->grid(2)
                                    ->label('Add Option Value'),
                            ])

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
