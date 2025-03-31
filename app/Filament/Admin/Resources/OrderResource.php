<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Filament\Admin\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
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

    protected static ?string $navigationGroup = 'Orders & Clients';

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
                                    ->hidden(fn($record) => empty($record->manual_discount))
                                    ->label('Manual discount'),
                        TextEntry::make('used_promo')
                            ->hidden(fn($record) => empty(array_key_first(json_decode($record->used_promo, true))))
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
                        Forms\Components\Grid::make(2)
                            ->schema([
                        Forms\Components\Fieldset::make('Order stage')
                            ->schema([
                                Select::make('status_id')
                                    ->label('Status')
                                    ->relationship('status', 'name')
                                    ->required(),
                            ])
                            ->columnSpan(1),
                        Forms\Components\Fieldset::make('Payment')
                            ->relationship('payment')
                            ->schema([
                                Forms\Components\Placeholder::make('status')
                                    ->label('Payment status')
                                    ->inlineLabel()
                                ->content(fn($get) => $get('status'))
                                    ->extraAttributes(fn ($get) => [
                                        'class' => $get('status') === 'success' ? 'text-green-600 font-bold' : 'text-red-600 font-bold',
                                    ])
                                ->columnSpanFull(),
                            ])
                            ->columnSpan(1),
                        ])
                        ,
                        Forms\Components\Fieldset::make('Client info')
                            ->relationship('orderInfo')
                            ->schema([
                                TextInput::make('full_name'),
                                TextInput::make('email'),
                                TextInput::make('phone'),
                                TextInput::make('shipping_address'),
                                TextInput::make('billing_address'),
                                Actions::make([
                                    Action::make('view_client')
                                        ->label('View Client Card')
                                        ->icon('heroicon-o-user')
                                        ->url(fn ($get) => route('filament.admin.resources.users.edit', $get('../user_id')))
                                        ->openUrlInNewTab(),
                                ])->alignRight()
                                ->verticallyAlignCenter(),
                            ]),


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
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('status.name'),
                TextColumn::make('orderInfo.full_name')->label('Full Name'),
                TextColumn::make('orderInfo.email')->label('Email'),
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
