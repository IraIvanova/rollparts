<?php

namespace App\Filament\Admin\Resources\WebsiteSettingResource\Pages;

use App\Filament\Admin\Resources\WebsiteSettingResource;
use App\Models\WebsiteSettings;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditWebsiteSetting extends EditRecord
{
    protected static string $resource = WebsiteSettingResource::class;

    public function getRecord(): Model
    {
        return WebsiteSettings::first();
    }

    protected function getHeaderActions(): array
    {
        return []; // Remove delete or replicate buttons
    }
}
