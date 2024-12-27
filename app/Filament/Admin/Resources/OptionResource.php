<?php

namespace App\Filament\Admin\Resources;

use App\Constant\OptionConstants;
use App\Filament\Admin\Resources\OptionResource\Pages;
use App\Models\Option;
use App\Models\UnitType;
use Filament\Actions\EditAction;
use Filament\Forms\Components\HasManyRepeater;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Resources\Resource;

class OptionResource extends Resource
{
    protected static ?string $model = Option::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Option Name')
                    ->required()
                    ->maxLength(255),

                Select::make('unit_type_id')
                    ->label('Unit Type')
                    ->options(UnitType::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Toggle::make('active')
                    ->label('Active')
                    ->default(true),
                Repeater::make('values')
                    ->label('Option Values')
                    ->schema([
                        TextInput::make('value')
                            ->label('Value')
                            ->required(),
                    ])
//                    ->dehydrateStateUsing(function ($state) {
//                        // Transform the repeater data into a simple array for saving
//                        return collect($state)->pluck('value')->toArray();
//                    })
//                    ->afterStateHydrated(function ($state, $set) {
//                        // Transform the saved array of values into repeater-compatible format
//                        $set('values', collect($state)->map(fn($value) => ['value' => $value])->toArray());
//                    })
//                    ->minItems(1) // Ensure at least one value is added
//                    ->saveAsJson() // Save the repe
                ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->searchable(),
                TextColumn::make('unitType.name')->label('Unit'),
                IconColumn::make('active')->label('Active')->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([

            ])
            ->bulkActions([
               DeleteBulkAction::make(),
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
            'index' => Pages\ListOptions::route('/'),
            'create' => Pages\CreateOption::route('/create'),
            'edit' => Pages\EditOption::route('/{record}/edit'),
        ];
    }
}
