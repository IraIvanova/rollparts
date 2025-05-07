<?php

namespace App\Filament\Admin\Forms;

use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;

class OrderClientInfoForm
{
    private const DEFAULT_BILLING_ADDRESS = 'Same as shipping address';

    public static function make(): Forms\Components\Section
    {
        return Forms\Components\Section::make()
            ->relationship('orderInfo')
            ->schema([
                Forms\Components\Fieldset::make('Client Information')
                    ->schema([
                        Grid::make()
                            ->schema(
                                array_merge(
                                    static::createClientDetailsSection(),
                                    static::createAddressSection(),
                                    static::createActionsSection()
                                )
                            )
                            ->columns(2),
                    ])
            ]);
    }

    private static function createClientDetailsSection(): array
    {
        return [
            TextInput::make('full_name')
                ->label('Full Name')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Email Address')
                ->email()
                ->required()
                ->maxLength(255),

            TextInput::make('phone')
                ->label('Phone Number')
                ->tel()
                ->required()
                ->maxLength(20),
        ];
    }

    private static function createAddressSection(): array
    {
        return [
            TextInput::make('shipping_address')
                ->label('Shipping Address')
                ->required()
                ->maxLength(255),

            TextInput::make('billing_address')
                ->label('Billing Address')
                ->default(self::DEFAULT_BILLING_ADDRESS)
                ->maxLength(255),
        ];
    }

    private static function createActionsSection(): array
    {
        return [
            Actions::make([
                Action::make('view_client')
                    ->label('View Client Card')
                    ->icon('heroicon-o-user')
                    ->url(fn($get) => route('filament.admin.resources.users.edit', $get('../user_id')))
                    ->visible(fn($get) => $get('user_id'))
                    ->openUrlInNewTab(),
            ])
                ->alignRight()
                ->verticallyAlignCenter(),
        ];
    }
}
