<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CouponResource\Pages;
use App\Filament\Admin\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Orders & Clients';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label('Coupon Code')
                    ->required()
                    ->maxLength(255),

                Select::make('discount_type')
                    ->label('Discount Type')
                    ->options([
                        'fixed' => 'Fixed Amount',
                        'percentage' => 'Percentage',
                    ])
                    ->required(),

                TextInput::make('discount_value')
                    ->label('Discount Value')
                    ->numeric()
                    ->required(),

                DatePicker::make('expires_at')
                    ->label('Expiration Date'),

                TextInput::make('minimum_order_amount')
                    ->label('Minimum Order Amount')
                    ->numeric()

                    ->nullable(),

                TextInput::make('usage_limit')
                    ->label('Usage Limit')
                    ->numeric()
                    ->nullable(),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Coupon Code')
                    ->searchable(),

                TextColumn::make('discount_type')
                    ->label('Discount Type'),

                TextColumn::make('discount_value')
                    ->label('Discount Value'),

                TextColumn::make('expires_at')
                    ->label('Expiration Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('minimum_order_amount')
                    ->label('Minimum Order Amount'),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
