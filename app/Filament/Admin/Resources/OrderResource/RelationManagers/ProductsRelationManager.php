<?php

namespace App\Filament\Admin\Resources\OrderResource\RelationManagers;

use App\DTO\CartProductDTO;
use App\Models\Order;
use App\Models\OrderProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderProducts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //todo: search input for product
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
                    ->getStateUsing(function (Model $record) {
                        return Media::query()
                            ->where('model_id', $record->id)
                            ->where('order_column', 1)
                            ->first()?->getFullUrl() ?? 'images/default.png';
                    })
                    ->height(150),
                Tables\Columns\TextColumn::make('translationByLanguage.name')
                    ->label('Name')
                    ->getStateUsing(function (Model $record) {
                        return $record->product->translationByLanguage()->first()?->name;
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
                Tables\Actions\EditAction::make()
                    ->using(function (Model $record, array $data): Model {
                        if ($stock = $record->product->stock) {
                            $previousAmount = $record->getOriginal('amount') ?? 0;
                            $newAmount = (int)$data['amount'];
                            $difference = $newAmount - $previousAmount;

                            if ($stock->quantity >= $difference) {
                                $stock->quantity -= $difference;
                                $stock->save();
                            }

                         $record->update(['amount' => $data['amount']]);
                        }

                        return $record;
                    })
                    ->form([
                        Forms\Components\TextInput::make('amount')
                            ->label('Amount')
                            ->numeric()
                            ->required()
                            ->rules(function (Model $record, $state) {
                                $stock = ($record->product->stock?->quantity + $record['amount']) ?? 0;
                                return [
                                    'numeric',
                                    'required',
                                    "max:{$stock}",
                                ];
                            })
                            ->helperText(function ($record) {
                                return "Available stock: " . ($record->product->stock?->quantity + (int)$record->getOriginal(
                                        'amount'
                                    ) ?? 0);
                            })
                    ])
                ,
                Tables\Actions\DeleteAction::make()
                    ->before(function (Model $record) {
                        if ($stock = $record->product->stock) {
                                $stock->quantity += $record->amount;
                                $stock->save();
                        }
                    }),
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
