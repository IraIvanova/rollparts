<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CarModelResource\Pages;
use App\Filament\Admin\Resources\CarModelResource\RelationManagers;
use App\Models\CarModel;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CarModelResource extends Resource
{
    protected static ?string $model = CarModel::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Car Models';
    protected static ?string $pluralModelLabel = 'Car Models';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('make_id')
                    ->label('Make')
                    ->relationship('make', 'name') // assumes CarModel belongsTo CarMake
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('model')
                    ->label('Model')
                    ->required()
                    ->maxLength(100),

                TextInput::make('engine')
                    ->label('Engine')
                    ->maxLength(50),

                TextInput::make('years')
                    ->label('Production Years')
                    ->maxLength(50),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('make.name')
                    ->label('Make')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('model')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('engine')
                    ->label('Engine'),

                Tables\Columns\TextColumn::make('years')
                    ->label('Years'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarModels::route('/'),
            'create' => Pages\CreateCarModel::route('/create'),
            'edit' => Pages\EditCarModel::route('/{record}/edit'),
        ];
    }
}
