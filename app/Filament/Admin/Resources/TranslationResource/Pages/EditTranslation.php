<?php

namespace App\Filament\Admin\Resources\TranslationResource\Pages;

use App\Filament\Admin\Resources\TranslationResource;
use App\Services\TranslationService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;


class EditTranslation extends EditRecord
{
    protected static string $resource = TranslationResource::class;
    protected TranslationService $translationService;

    // Inject TranslationService via constructor
    public function __construct()
    {
        $this->translationService = app(TranslationService::class);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Save translation files during the create operation
        $this->translationService->updateTranslationFiles($data['key'], $data['tr'], $data['en']);

        return $data; // Save data as is to the database
    }
}
