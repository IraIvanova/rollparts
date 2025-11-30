<?php

namespace App\Filament\Admin\Forms;

use App\Models\CarModel;
use App\Models\CarYear;
use App\Models\Color;
use App\Models\Currency;
use App\Models\Manufacturer;
use App\Services\Admin\Form\Fields\InputBuilder;
use App\Services\Admin\Form\Fields\SelectBuilder;
use App\Services\PriceCalculationService;
use App\Services\Store\ProductService;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;

class ProductDetailsForm
{
    public static function getComponents(): array
    {
        return [
            self::getTranslationsRepeater(),
            ...self::getGeneralDetailsGrid(),
            self::getCarModelsRepeater(),
            self::getCategoriesField(),
            self::getPricesRepeater(),
            self::getStockFieldset(),
        ];
    }

    protected static function getTranslationsRepeater(): Component
    {
        return Repeater::make('translations')
            ->label('Translations')
            ->relationship('translations')
            ->schema([
                SelectBuilder::make('language')->languagesType()->required(),
                InputBuilder::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->autoSlug(),
                RichEditor::make('description')
                    ->label('Description')
                    ->columnSpanFull()
                    ->nullable(),
            ])
            ->addActionLabel('Add translation')
            ->collapsible();
    }

    protected static function getGeneralDetailsGrid(): array
    {
        return [
            Grid::make()
                ->schema([
                    SelectBuilder::make('manufacturer_id')
                        ->relationship('manufacturer', 'name')
                        ->searchable()
                        ->preload(),
                    TextInput::make('slug')
                        ->required()
                        ->rules(['alpha_dash'])
                        ->disabledOn('edit')
                        ->unique('products', 'slug', ignoreRecord: true),
                    TextInput::make('mnf_code'),
                    Select::make('color_id')
                        ->relationship('color', 'name')
                        ->searchable()
                        ->preload(),
                ]),
        ];
    }

    protected static function getCarModelsRepeater(): Component
    {
        return Repeater::make('carModelProducts')
            ->label('Car Model & Year')
            ->relationship('carModelProducts',)
            ->schema([
                Select::make('car_model_id')
                    ->label('Car Model')
                    ->options(CarModel::pluck('model', 'id'))
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('car_year_id', $state
                            ? CarYear::where('car_model_id', $state)->orderBy('year')->value('id')
                            : null);
                    })
                    ->reactive()
                    ->searchable()
                    ->required(),
                Select::make('car_year_id')
                    ->label('Year')
                    ->options(fn (callable $get) => $get('car_model_id')
                        ? CarYear::where('car_model_id', $get('car_model_id'))->pluck('year', 'id')
                        : [])
                    ->required()
                    ->rules([
                        function ($component, $get) {
                            return function (string $attribute, $value, \Closure $fail) use ($component, $get) {
                                $items = $component->getContainer()->getParentComponent()->getState();
                                $selectedModel = $get('car_model_id');

                                $count = collect($items)
                                    ->where('car_model_id', $selectedModel)
                                    ->where('car_year_id', $value)
                                    ->count();

                                if ($count > 1) {
                                    $fail('This car model and year combination has already been added.');
                                }
                            };
                        },
                    ]),
            ])
            ->grid();
    }

    protected static function getCategoriesField(): Component
    {
        return SelectTree::make('categories')
            ->relationship('categories', 'name', 'parent_id')
            ->enableBranchNode()
            ->searchable();
    }

    protected static function getPricesRepeater(): Component
    {
        return Repeater::make('prices')
            ->label('Product Prices')
            ->relationship('prices')
            ->schema([
                TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->live(onBlur: true)
                    ->prefix('₺')
                    ->afterStateUpdated(fn ($state, callable $get, callable $set) => self::updateDiscountedPrice($set, $state, $get('discount_amount'))),
                Select::make('currency_id')
                    ->label('Currency')
                    ->options(Currency::pluck('code', 'id'))
                    ->default(1)
                    ->dehydrated()
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
                    ->afterStateUpdated(fn ($state, callable $get, callable $set) => self::updateDiscountedPrice($set, $get('price'), $state)),
                TextInput::make('discounted_price')
                    ->label('Price with Discount')
                    ->numeric()
                    ->reactive()
                    ->prefix('₺')
                    ->afterStateUpdated(fn ($state, callable $get, callable $set) => self::updateDiscountPercent($set, $get('price'), $state)),
            ])
            ->defaultItems(1)
            ->minItems(1)
            ->maxItems(10)
            ->addActionLabel('Add price')
            ->columns(2)
            ->columnSpanFull();
    }

    protected static function updateDiscountedPrice(callable $set, mixed $price, mixed $discount): void
    {
        if ($price !== null && $discount !== null) {
            $set('discounted_price', PriceCalculationService::calculateDiscountedPrice((float) $price, (float) $discount));
        }
    }

    protected static function updateDiscountPercent(callable $set, mixed $price, mixed $discountedPrice): void
    {
        if ($price && $discountedPrice !== null) {
            $set('discount_amount', PriceCalculationService::calculateDiscountPercent((float) $price, (float) $discountedPrice));
        }
    }

    protected static function getStockFieldset(): Component
    {
        return Fieldset::make('Stock')
            ->relationship('stock')
            ->schema([
                TextInput::make('quantity')
                    ->numeric()
                    ->label('Quantity')
                    ->required(),
            ]);
    }
}
