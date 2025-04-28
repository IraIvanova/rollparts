<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\InventoryResource\RelationManagers\InventoryRelationManager;
use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Filament\Admin\Resources\ProductResource\RelationManagers\FrequentlyBoughtTogetherRelationManager;
use App\Filament\Admin\Resources\ProductResource\RelationManagers\ImagesRelationManager;
use App\Filament\Admin\Resources\ProductResource\RelationManagers\ProductOptionsRelationManager;
use App\Filament\Admin\Resources\ProductResource\RelationManagers\VariantsRelationManager;
use App\Models\CarModel;
use App\Models\CarYear;
use App\Models\Color;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Services\Store\ProductService;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 3;


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
                                            ->default('tr')
                                            ->required()
                                            ->searchable(),
                                        TextInput::make('name')
                                            ->label('Name')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(
                                                fn(Set $set, ?string $state) => $set('../../slug', Str::slug($state))
                                            ),
                                        RichEditor::make('description')
                                            ->label('Description')
                                            ->columnSpanFull()
                                            ->nullable(),
                                    ])
                                    ->addActionLabel('Add translation')
                                    ->collapsible(),
                                Grid::make(2)
                                    ->schema([
                                        Select::make('manufacturer_id')
                                            ->label('Manufacturer')
                                            ->options(Manufacturer::all()->pluck('name', 'id')),
                                        TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->rules(['alpha_dash'])
                                            ->disabledOn('edit')
                                            ->unique('products', 'slug', ignoreRecord: true),
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('mnf_code')
                                            ->maxLength(255),
                                        Select::make('color_id')
                                            ->options(Color::all()->pluck('name', 'id')),
                                    ]),
                                Repeater::make('carModels')
                                    ->label('Car Model & Year')
                                    ->relationship('carModelProducts')
                                    ->schema([
                                        Select::make('car_model_id')
                                            ->label('Car Model')
                                            ->options(CarModel::all()->pluck('model', 'id'))
                                            ->afterStateUpdated(function ($state, callable $set) {
                                                $firstYear = CarYear::where('car_model_id', $state)->orderBy(
                                                    'year'
                                                )->first();
                                                $set('car_year_id', $firstYear?->id);
                                            })
                                            ->reactive()
                                            ->searchable()
                                            ->required(),
                                        Select::make('car_year_id')
                                            ->label('Year')
                                            ->options(function (callable $get) {
                                                $modelId = $get('car_model_id');
                                                return $modelId
                                                    ? CarYear::where('car_model_id', $modelId)->pluck('year', 'id')
                                                    : [];
                                            })
                                            ->required(),
                                    ])
                                    ->grid(2),

                                SelectTree::make('categories')
                                    ->relationship('categories', 'name', 'parent_id')
                                    ->enableBranchNode()
                                    ->searchable(),
                                Repeater::make('prices')
                                    ->label('Product Prices')
                                    ->relationship('prices')
                                    ->schema([
                                        TextInput::make('price')
                                            ->label('Price')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->prefix('₺')
                                            ->afterStateUpdated(
                                                function ($state, callable $get, callable $set) {
                                                    $discount = $get('discount_amount');
                                                    if ($discount !== null) {
                                                        $discountedPrice = ProductService::calculateDiscountedPrice(
                                                            $state,
                                                            $discount
                                                        );
                                                        $set('discounted_price', $discountedPrice);
                                                    }
                                                }
                                            ),
                                        Select::make('currency_id')
                                            ->label('Currency')
                                            ->options(Currency::pluck('code', 'id'))
                                            ->default(1)
                                            ->hidden()
                                            ->required(),
                                        TextInput::make('cargo_price')
                                            ->label('Cargo Price')
                                            ->default(250)
                                            ->required()
                                            ->prefix('₺'),
                                        TextInput::make('discount_amount')
                                            ->label('Discount (%)')
                                            ->default(0)
                                            ->live(onBlur: true)
                                            ->prefix('%')
                                            ->afterStateUpdated(
                                                function ($state, callable $get, callable $set) {
                                                    $price = $get('price');
                                                    if ($price !== null) {
                                                        $discountedPrice = ProductService::calculateDiscountedPrice(
                                                            $price,
                                                            $state
                                                        );
                                                        $set('discounted_price', $discountedPrice);
                                                    }
                                                }
                                            ),
                                        TextInput::make('discounted_price')
                                            ->label('Price with Discount')
                                            ->numeric()
                                            ->reactive()
                                            ->prefix('₺')
                                            ->afterStateUpdated(
                                                function ($state, callable $get, callable $set, ?Model $record) {
                                                    $price = $get('price');
                                                    if ($price && $state !== null) {
                                                        $discountPercent = ProductService::calculateDiscountPercent(
                                                            $price,
                                                            $state
                                                        );
                                                        $set('discount_amount', $discountPercent);
                                                    }
                                                }
                                            ),
                                    ])
                                    ->defaultItems(1)
                                    ->minItems(1)
                                    ->maxItems(10)
                                    ->addActionLabel('Add price')
                                    ->columns(2)
                                    ->columnSpanFull(),
                                Fieldset::make('Stock')
                                    ->relationship('stock')
                                    ->schema([
                                        TextInput::make('quantity')
                                            ->numeric()
                                            ->label('Quantity')
                                            ->required(),
                                    ]),
                            ]),
                        Tab::make('Product Images & Files')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('attachments')
                                    ->collection('products')
                                    ->conversion('thumb')
                                    ->multiple()
                                    ->reorderable()
                                    ->image()
                            ]),
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
