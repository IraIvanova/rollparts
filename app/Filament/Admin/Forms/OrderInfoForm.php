<?php

namespace App\Filament\Admin\Forms;

use App\Models\Order;
use App\Models\Status;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

class OrderInfoForm
{
    public static function makeCreateFormSections(): Fieldset
    {
        return Fieldset::make('Order stage')
            ->schema(
                self::getCommonFields()
            )
            ->columnSpan(1);
    }

    public static function makeEditFormSections(): Fieldset
    {
        return Fieldset::make('Order stage')
            ->schema(
                array_merge(
                    [
                        Forms\Components\Placeholder::make('id')
                            ->label('Order ID')
                            ->inlineLabel()
                            ->content(fn($get) => $get('id'))
                            ->columnSpanFull(),
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created_at')
                            ->inlineLabel()
                            ->content(fn($record) => $record?->created_at->format('d.m.Y H:i:s'))
                            ->columnSpanFull(),
                    ],
                    self::getCommonFields()
                )
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
