<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Filament\Admin\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected $listeners = ['refresh' => '$refresh'];

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                    ])
                    ->schema([
                        Fieldset::make('Order info')
                            ->schema([
                                TextEntry::make('id')
                                    ->label('Order ID'),
                                TextEntry::make('created_at')
                                    ->label('Order Date'),
                                TextEntry::make('status.name')
                                    ->label('Order Status'),
                            ])
                            ->columns(1)
                            ->columnSpan(1),
                        Fieldset::make('Client info')
                            ->schema([
                                TextEntry::make('client.fullName')
                                    ->label('Customer Name'),
                                TextEntry::make('clientShippingAddress.fullAddress')
                                    ->label('Customer Address'),
                                TextEntry::make('client.phone')
                                    ->label('Phone number'),
                                TextEntry::make('client.email')
                                    ->label('Email'),
                            ])
                            ->columns(1)
                            ->columnSpan(1),
                    ]),
                Section::make()
                    ->schema([
                        Fieldset::make('Order total & applied discounts')
                            ->schema([
                                TextEntry::make('total_price_with_discount')
                                    ->weight(FontWeight::Bold)
                                    ->label('Final Price')
                                    ->money('trl'),
                                TextEntry::make('total_price')
                                    ->label('Net price')
                                    ->money('trl'),
                                TextEntry::make('manual_discount')
                                    ->label('Manual discount'),
                        TextEntry::make('used_promo')
                            ->label('Used promo code'),
                            ])
                    ])
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
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
                Select::make('status_id')
                    ->label('Status')
                    ->relationship('status', 'name')
                    ->required(),
                ]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Fieldset::make('Order total & applied discounts')
                            ->schema([
                                TextInput::make('total_price_with_discount')
                                    ->label('Final Price')
                                    ->disabled(),
                                TextInput::make('total_price')
                                    ->label('Net price')
                                    ->disabled(),
                                TextInput::make('manual_discount')
                                    ->numeric()
                                    ->label('Manual discount'),
                        TextInput::make('used_promo')
                            ->label('Used promo code')
                            ->disabled(),
                            ])
                    ])
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
            ])
//            ->footer(function ($records) {
//                $total = $records->sum(function ($record) {
//                    $price = $record->discounted_price ?? $record->price;
//                    return $price * $record->amount;
//                });
//
//                return "Order Total: " . number_format($total, 2) . " TRL";
//            })
            ;
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
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
