<?php

namespace App\Filament\Admin\Resources\OrderResource\Pages;

use App\Filament\Admin\Forms\OrderClientInfoForm;
use App\Filament\Admin\Resources\OrderResource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;


class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('New Order')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Select::make('status_id')
                                ->label('Status')
                                ->relationship('status', 'name')
                                ->required(),

                            Textarea::make('notes')
                                ->label('Order notes')
                                ->columnSpanFull(),
                        ]),
                    OrderClientInfoForm::make(),
                ]),
        ]);
    }
}
