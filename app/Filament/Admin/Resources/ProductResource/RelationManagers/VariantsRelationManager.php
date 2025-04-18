<?php

namespace App\Filament\Admin\Resources\ProductResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'productVariants';
    protected static ?string $recordTitleAttribute = 'variant_id';
    protected static ?string $label = 'Color variants';

    public function form(Form $form): Form
    {
        return $form->schema([
            Select::make('product_id')
                ->label('Product')
                ->searchable()
                ->getSearchResultsUsing(function (string $query) {
                    return \App\Models\ProductTranslation::where('name', 'like', "%{$query}%")
                        ->whereNot('product_id', $this->ownerRecord->id)
                        ->limit(20) // Limit results for performance
                        ->pluck('name', 'product_id'); // Return id => name pairs
                })
                ->required(),
//            Select::make('variant_id')
//                ->label('Variant')
//                ->relationship('variant.translationByLanguage', 'name')  // Assuming the variant relationship exists on the Product model
//                ->required(),

            Select::make('color_id')
                ->label('Color')
                ->relationship('color', 'name')  // Assuming the color relationship exists
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('variant.name')->label('Variant'),
                TextColumn::make('color.name')->label('Color'),
                TextColumn::make('created_at')->label('Created At')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
