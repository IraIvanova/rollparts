<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Filament\Admin\Resources\OrderResource\RelationManagers;
use App\Models\Client;
use App\Models\ClientAddress;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('id')
                    ->label('Order ID'),
                TextEntry::make('client.fullName')
                    ->label('Customer Name'),
                TextEntry::make('clientShippingAddress.fullAddress')
                    ->label('Customer Address'),
                TextEntry::make('client.phone')
                    ->label('Phone number'),
                TextEntry::make('client.email')
                    ->label('Email'),
                TextEntry::make('status.name')
                    ->label('Order Status'),
                TextEntry::make('created_at')
                    ->label('Order Date'),
                RepeatableEntry::make('orderProducts')
                    ->schema([
//                    TextEntry::make('author.name'),
//                    TextEntry::make('title'),
                    TextEntry::make('slug')
                        ->columnSpan(2),
                ])
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Client (with client name, email, and phone)
                Select::make('client_id')
                    ->label('Client')
                    ->relationship('client', 'fullName')
                    ->required()
                    ->searchable(),
//                    ->getOptionLabelUsing(fn (Client $client) => $client->name . ' (' . $client->email . ')'),

                // Show Client Address - Billing or Shipping
                Select::make('client_address_id')
                    ->label('Client Address')
                    ->relationship('clientAddresses', 'address_line1')
                    ->required(),
//                    ->searchable(),
//                    ->getOptionLabelUsing(fn (ClientAddress $address) => $address->address_line1 . ', ' . $address->city . ' ' . $address->zip),

                // Order Status
               Select::make('status_id')
                    ->label('Status')
                    ->relationship('status', 'name')
                    ->required(),

                // Repeater for Products in the Order
                Repeater::make('orderProducts')
                    ->label('Products')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->relationship('product', 'name')
                            ->required(),
                        Forms\Components\TextInput::make('amount')->required(),
                        Forms\Components\TextInput::make('price')->required(),
                        Forms\Components\TextInput::make('discounted_price')->required(),
                    ])
                    ->columns(2)
                    ->defaultItems(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('status.name'),
                TextColumn::make('created_at'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
