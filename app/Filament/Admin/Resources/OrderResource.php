<?php

namespace App\Filament\Admin\Resources;

use App\Constant\StatusesConstants;
use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Filament\Admin\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Orders & Clients';

    protected $listeners = ['refresh' => '$refresh'];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(fn(Builder $query) => $query->where('status_id', '!=', StatusesConstants::PENDING))
            ->columns([
                TextColumn::make('id')->searchable(),
                TextColumn::make('status.name'),
                TextColumn::make('orderInfo.full_name')->label('Full Name')->searchable(),
                TextColumn::make('orderInfo.email')->label('Email') ->searchable(),
                TextColumn::make('created_at'),
            ])
            ->filters([
                SelectFilter::make('status_id')
                ->label('Status')
                ->relationship('status', 'name')
                ->searchable()
                ->preload()
                ->multiple(),
//                Filter::make('excludeStatus')
//                    ->query(fn ($query) => $query->where('status_id', '!=', StatusesConstants::PENDING))
//                    ,
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
            RelationManagers\ProductsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
