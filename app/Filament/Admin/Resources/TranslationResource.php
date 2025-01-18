<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TranslationResource\Actions\EditTranslation;
use App\Filament\Admin\Resources\TranslationResource\Pages;
use App\Filament\Admin\Resources\TranslationResource\RelationManagers;
use App\Models\Translation;
use App\Services\TranslationService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TranslationResource extends Resource
{
    protected static ?string $model = Translation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->required(),
                Forms\Components\Textarea::make('en')
                    ->columnSpanFull()
                    ->rows(5),
                Forms\Components\Textarea::make('tr')
                    ->required()
                    ->columnSpanFull()
                    ->rows(5)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')->sortable(),
                TextColumn::make('en')->sortable(),
                TextColumn::make('tr')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->after(function ($record) {
                        app(TranslationService::class)->removeTranslationKey($record->key);
                    }),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTranslations::route('/'),
            'create' => Pages\CreateTranslation::route('/create'),
            'edit' => Pages\EditTranslation::route('/{record}/edit'),
        ];
    }
}
