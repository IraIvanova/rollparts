<?php

namespace App\Filament\Admin\Resources\ProductResource\RelationManagers;

use App\Filament\Admin\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductTranslation;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'productVariants';

    public function form(Form $form): Form
    {
        return $form->schema([
            Select::make('product_id')
                ->label('Product')
                ->searchable()
                ->reactive()
                ->getSearchResultsUsing(function (string $query) {
                    return ProductTranslation::where('name', 'like', "%{$query}%")
                        ->whereNot('product_id', $this->ownerRecord->id)
                        ->limit(20)
                        ->pluck('name', 'product_id');
                })
                ->required(),
            Placeholder::make('color')
                ->label('Color')
                ->content(function ($get) {
                    $product = Product::with('color')->find($get('product_id'));
                    $color = $product->color;

                    if (!$color) {
                        return 'No color';
                    }

                    return new HtmlString(
                        '<div style="display: flex; align-items: center; gap: 8px;">
                <div style="width: 20px; height: 20px; background-color: ' . $color->hex_code . '; border: 1px solid #ccc; border-radius: 4px;"></div>
                <span>' . e($color->name) . '</span>
            </div>'
                    );
                })
                ->visible(fn($get) => filled($get('product_id'))),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('translationByLanguage.name')
                    ->label('Name')
                    ->getStateUsing(function (Model $record) {
                        return $record->translationByLanguage()->first()?->name;
                    }),
                Tables\Columns\TextColumn::make('color.name')
                    ->label('Color')
                    ->getStateUsing(function (Model $record) {
                        $color = $record->color;

                        if (!$color) {
                            return 'No color';
                        }

                        return new HtmlString(
                            '<div style="display: flex; align-items: center; gap: 8px;">
                <div style="width: 20px; height: 20px; background-color: ' . $color->hex_code . '; border: 1px solid #ccc; border-radius: 4px;"></div>
                <span>' . e($color->name) . '</span>
            </div>'
                        );
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->using(function (array $data, Product $product) {
                        $relatedProduct = Product::find($data['product_id']);

                        $this->ownerRecord->productVariants()->syncWithoutDetaching([$relatedProduct->id]);
                        $relatedProduct->productVariants()->syncWithoutDetaching([$this->ownerRecord->id]);

                        return $product;
                    }),
            ])
            ->actions([
                EditAction::make()
                    ->url(fn(Model $record): string => ProductResource::getUrl('edit', [$record->id])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
