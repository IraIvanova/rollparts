<?php

namespace App\Filament\Admin\Forms;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ProductMediaForm
{
    public static function getComponents(): array
    {
        return [
            self::getImagesUpload(),
        ];
    }

    protected static function getImagesUpload(): Component
    {
        return SpatieMediaLibraryFileUpload::make('attachments')
            ->collection('products')
            ->conversion('thumb')
            ->multiple()
            ->reorderable()
            ->image();
    }
}
