<?php

namespace App\Filament\Admin\Forms;

use App\Models\Order;
use App\Models\Status;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class ClientForm
{
    public static function makeClientForOrderPage(): array
    {
        return [
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('lastName')
                    ->maxLength(255),
                TextInput::make('phone')
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('identity')
                    ->email()
                    ->maxLength(255),
            ];
    }

    public static function makeClientPageForm(): Fieldset
    {
        return Fieldset::make('Client info')
            ->schema(
                [
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('lastName')
                        ->maxLength(255),
                    TextInput::make('phone')
                        ->maxLength(255),
                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),
//                Password::make('password')
//                    ->dehydrateStateUsing(fn($state) => $state ? bcrypt($state) : null)
//                    ->required(fn($record) => !$record),
                    Select::make('roles')
                        ->multiple()
                        ->relationship('roles', 'name')
                        ->preload()
                        ->required(),
                    Checkbox::make('is_admin')
                        ->label('Admin Panel User')
                        ->visible(false)
                        ->default(false),
                ]
            )
            ->columnSpan(1);
    }

    private static function getCommonFields(): array
    {
        return [
            Select::make('status_id')
                ->label('Status')
                ->inlineLabel()
                ->relationship('status', 'name')
                ->options(function (callable $get, ?Order $record) {
                    return Status::getAllowedStatuses($record?->status_id);
                })
                ->columnSpanFull()
                ->required(),
            Textarea::make('notes')
                ->label('Order notes')
                ->columnSpanFull()
        ];
    }
}
