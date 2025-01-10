<?php

namespace App\Filament\Admin\Resources\OrderResource\RelationManagers;

use App\DTO\CartProductDTO;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductPrice;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderProducts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
        //todo: search input for product
                Forms\Components\Select::make('product_id')
                    ->label('Product')
                    ->searchable()
                    ->getSearchResultsUsing(function (string $query) {
                        $existingProductIds = $this->ownerRecord->orderProducts->pluck('product_id')->toArray();

                        return \App\Models\ProductTranslation::where('name', 'like', "%{$query}%")
                            ->whereNotIn('product_id', $existingProductIds)
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
                Tables\Actions\CreateAction::make()
                    ->using(function (array $data, string $model): Model {
                        $prices = ProductPrice::where('product_id', $data['product_id'])->where('currency_id', 1)->first();
                        $data['price'] = $prices->price;
                        $data['discounted_price'] = $prices->discounted_price;
                        $data['order_id'] = $this->ownerRecord->id;
                        $data['amount'] = 1;

                        return $model::create($data);
                    })
                    ->after(function ($action) {
                        $action->getLivewire()->dispatch('refreshForm');
                    })
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
                    ->after(function ($action) {
                        // Runs after the form fields are saved to the database.
                        $action->getLivewire()->dispatch('refreshForm');
                    })
                ,
                Tables\Actions\DeleteAction::make()
                    ->before(function (Model $record) {
                        if ($stock = $record->product->stock) {
                                $stock->quantity += $record->amount;
                                $stock->save();
                        }
                    })
                    ->after(function ($action) {
                        // Runs after the form fields are saved to the database.
                        $action->getLivewire()->dispatch('refreshForm');
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
