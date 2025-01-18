<?php

namespace App\Filament\Admin\Resources\TranslationResource\Pages;

use App\Filament\Admin\Resources\TranslationResource;
use App\Services\TranslationService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTranslation extends CreateRecord
{
    protected static string $resource = TranslationResource::class;
    protected TranslationService $translationService;

    // Inject TranslationService via constructor
    public function __construct()
    {
        $this->translationService = app(TranslationService::class);
    }

    protected function afterCreate(): void
    {
        // Get the key and values from the record
        $key = $this->record->key;
        $trValue = $this->record->tr; // Turkish translation
        $enValue = $this->record->en; // English translation

        // Call the TranslationService to update the files
        $this->translationService->updateTranslationFiles($key, $trValue, $enValue);
    }
}
