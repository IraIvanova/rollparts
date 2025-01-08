<?php

namespace App\Filament\Admin\Resources\OrderResource\RelationManagers;

use App\Services\Store\ProductService;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderProducts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
//                Forms\Components\TextInput::make('name')
//                    ->required()
//                    ->maxLength(255),
                Forms\Components\TextInput::make('translationByLanguage.name')
                    ->label('Product')
                    ->required(),
//                Forms\Components\TextInput::make('quantity')
//                    ->label('Quantity')
//                    ->numeric()
//                    ->required(),
//                Forms\Components\TextInput::make('price')
//                    ->label('Price')
//                    ->numeric()
//                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->getStateUsing( function (Model $record){
                        return Media::query()
                            ->where('model_id', $record->id)
                            ->where('order_column', 1)
                            ->first()?->getFullUrl() ?? 'images/default.png';
                    })
                ->height(150),
                Tables\Columns\TextColumn::make('translationByLanguage.name')
                    ->label('Name')
                    ->getStateUsing( function (Model $record){
                        return $record->translationByLanguage()->first()?->name;
                    }),
                Tables\Columns\TextColumn::make('amount')
                ->label('Qnt'),
                Tables\Columns\TextColumn::make('price')->money('trl'),
                Tables\Columns\TextColumn::make('discounted_price')->money('trl'),
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
            ])
                ->striped()
                ->paginated(false);
    }
}
