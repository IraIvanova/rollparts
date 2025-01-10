<?php

namespace App\Filament\Admin\Resources\ProductResource\RelationManagers;

use App\Filament\Admin\Resources\ProductResource;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FrequentlyBoughtTogetherRelationManager extends RelationManager
{
    protected static string $relationship = 'frequentlyBoughtTogether';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Product')
                    ->searchable()
                    ->getSearchResultsUsing(function (string $query) {
                        return \App\Models\ProductTranslation::where('name', 'like', "%{$query}%")
                            ->whereNot('product_id', $this->ownerRecord->id)
                            ->limit(20) // Limit results for performance
                            ->pluck('name', 'product_id'); // Return id => name pairs
                    })
                    ->required(),
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
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->using(function (array $data, Product $product) {
                    $relatedProduct = Product::find($data['product_id']);

                    $this->ownerRecord->frequentlyBoughtTogether()->syncWithoutDetaching([$relatedProduct->id]);
                    $relatedProduct->frequentlyBoughtTogether()->syncWithoutDetaching([$this->ownerRecord->id]);

                    return $product;
                }),
            ])
            ->actions([
                EditAction::make()
                    ->url(fn (Model $record): string => ProductResource::getUrl('edit', [$record->id])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
