<?php

namespace App\Filament\Admin\Resources\CarMakeResource\Pages;

use App\Filament\Admin\Resources\CarMakeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCarMakes extends ListRecords
{
    protected static string $resource = CarMakeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
