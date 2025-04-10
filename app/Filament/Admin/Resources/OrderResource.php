<?php

namespace App\Filament\Admin\Resources;

use App\Constant\StatusesConstants;
use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Filament\Admin\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\Status;
use App\Services\OrderService;
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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                                    ->label('Order ID')
                                    ->inlineLabel(),
                                TextEntry::make('created_at')
                                    ->label('Order Date')
                                    ->inlineLabel(),
                                TextEntry::make('status.name')
                                    ->label('Order Status')
                                    ->inlineLabel(),
                                TextEntry::make('notes')
                                    ->label('Order notes')
                                    ->inlineLabel(),
                            ])
                            ->columns(1)
                            ->columnSpan(1),
                        Fieldset::make('Payment')
                            ->schema([
                                TextEntry::make('payment.status')
                                    ->label('Payment status')
                                    ->inlineLabel()
                                    ->default('No payment information available')
                                    ->columnSpanFull(),
                                TextEntry::make('payment.transaction_timestamp')
                                    ->label('Created at')
                                    ->inlineLabel()
                                    ->visible(fn($record) => $record->payment->transaction_timestamp)
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(1),
                    ]),
                Section::make()
                    ->schema([
                        Fieldset::make('Client info')
                            ->schema([
                                TextEntry::make('client.fullName')
                                    ->label('Customer Name')
                                    ->inlineLabel(),
                                TextEntry::make('client.phone')
                                    ->label('Phone number')
                                    ->inlineLabel(),
                                TextEntry::make('client.email')
                                    ->label('Email')
                                    ->inlineLabel(),
                                TextEntry::make('client.shippingAddress.fullAddress')
                                    ->label('Shipping Address')
                                    ->inlineLabel(),
                                TextEntry::make('client.billingAddress.fullAddress')
                                    ->label('Billing Address')
                                    ->default('Same as shipping address')
                                    ->inlineLabel(),
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
                                    ->label('Final Price with discount')
                                    ->prefix('TRL ')
                                ->extraAttributes(['class' => 'success']),
                                TextEntry::make('total_price')
                                    ->label('Total price')
                                    ->prefix('TRL '),
                                TextEntry::make('manual_discount')
                                    ->hidden(fn($record) => empty($record->manual_discount))
                                    ->label('Manual discount')
                                    ->prefix('TRL '),
                                TextEntry::make('used_promo')
                                    ->hidden(
                                        fn($record) => empty(array_key_first(json_decode($record->used_promo, true)))
                                    )
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
                                            ->options(function (callable $get, ?Order $record) {
                                                return Status::getAllowedStatuses($record->status_id);
                                            })
                                            ->required(),
                                    ])
                                    ->columnSpan(1),
                                Forms\Components\Fieldset::make('Payment')
                                    ->relationship('payment')
                                    ->schema([
                                        Forms\Components\Placeholder::make('status')
                                            ->label('Payment status')
                                            ->inlineLabel()
                                            ->content(function ($get) {
                                                $status = $get('status');

                                                if ($status) return $status;

                                                return 'No payment information available';
                                            })
                                            ->extraAttributes(fn($get) => [
                                                'class' => $get(
                                                    'status'
                                                ) === 'success' ? 'text-green-600 font-bold' : 'text-red-600 font-bold',
                                            ])
                                            ->columnSpanFull(),
                                        Forms\Components\Placeholder::make('transaction_timestamp')
                                            ->label('Created at')
                                            ->inlineLabel()
                                            ->content(fn($get) => $get('transaction_timestamp'))
                                            ->visible(fn($get) => $get('transaction_timestamp'))
                                            ->columnSpanFull(),
                                        Forms\Components\Placeholder::make('notes')
                                            ->label('Order notes')
                                            ->inlineLabel()
                                            ->content(fn($get) => $get('notes'))
                                            ->visible(fn($get) => $get('notes'))
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
                                TextInput::make('billing_address')
                                ->default('Same as shipping address'),
                                Actions::make([
                                    Action::make('view_client')
                                        ->label('View Client Card')
                                        ->icon('heroicon-o-user')
                                        ->url(
                                            fn($get) => route('filament.admin.resources.users.edit', $get('../user_id'))
                                        )
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
                                    ->numeric()
                                    ->reactive()
                                    ->afterStateHydrated(function (callable $set, callable $get) {
                                        $discount = $get('manual_discount') ?? 0;
                                        $set('total_price_with_discount', +number_format($get('total_price_with_discount') - $discount, 2, '.', ''));
                                    })
                                    ->disabled(),
                                TextInput::make('total_price')
                                    ->label('Net price')
                                    ->disabled(),
                                TextInput::make('manual_discount')
                                    ->numeric()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set, callable $get, Order $record) {
                                        $set('total_price_with_discount', OrderService::calculateTotalPriceWithManualDiscount($record, $state));
                                    })
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
