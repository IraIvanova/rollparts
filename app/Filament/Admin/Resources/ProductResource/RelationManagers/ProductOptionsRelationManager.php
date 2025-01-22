<?php

namespace App\Filament\Admin\Resources\ProductResource\RelationManagers;

use App\Models\Option;
use App\Models\ProductTranslation;
use App\Services\ProductOptionsService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Table;

class ProductOptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'productOptions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('option')
                    ->label('Option')
                    ->options(function () {
                        return Option::pluck('name', 'name');
                    })
                    ->live()
                    ->required(),
                Forms\Components\Select::make('option_value')
                    ->label('Option Value')
                    ->options(function (callable $get) {
                        if (!$optionName = $get('option')) {
                            return [];
                        }

                        $option = Option::where('name', $optionName)->first();
                        if (!$option || !is_array($option->values)) {
                            return [];
                        }

                        return collect($option->values)
                            ->pluck('value', 'value')
                            ->toArray();
                    })
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                    ->reactive()
                    ->required(),
                Forms\Components\Select::make('related_product_id')
                    ->label('Related Product')
                    ->searchable()
                    ->getSearchResultsUsing(function (string $query) {
                        return ProductTranslation::where('name', 'like', "%{$query}%")
                            ->limit(20)
                            ->pluck('name', 'product_id');
                    })
                    ->getOptionLabelUsing(fn ($value): ?string => ProductTranslation::where('product_id', $value)->first()?->name),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('option')
            ->columns([
                Tables\Columns\TextColumn::make('option')
                    ->label('Option'),
                Tables\Columns\TextColumn::make('option_value')
                    ->label('Option Value'),
                Tables\Columns\TextColumn::make('relatedProduct.translation_name')
                    ->label('Related Product'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
//                CreateAction::make()
//                    ->label('Add Related Product')
//                    ->action(function ($record, array $data) {
//                        ProductOptionsService::addBidirectionalRelationship(
//                            $this->ownerRecord->id,
//                            $data['related_product_id'],
//                            $data['option'],
//                            $data['option_value']
//                        );
//                    }),
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
