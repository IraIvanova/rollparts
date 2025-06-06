<?php

namespace App\Filament\Admin\Resources\ProductResource\Pages;

use App\Filament\Admin\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    public function getRecord(): Model
    {
        return parent::getRecord()->load('inventory');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Show on website')
                ->url(fn ($record) => route('product', [$record->slug]))
                ->icon('heroicon-o-link')
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}
