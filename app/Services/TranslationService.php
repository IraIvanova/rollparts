<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class TranslationService
{
    public function updateTranslationFiles(string $key, string $trValue, string $enValue): void
    {
        // Update Turkish translation file (lang/tr/interface.php)
        $this->updateTranslationFile('tr', $key, $trValue);

        // Update English translation file (lang/en/interface.php)
        $this->updateTranslationFile('en', $key, $enValue);
    }

    /**
     * Update a specific translation file (either 'tr' or 'en').
     */
    private function updateTranslationFile(string $lang, string $key, string $value): void
    {
        $filePath = lang_path("lang/{$lang}/interface.php");

        if (!File::exists($filePath)) {
            File::put($filePath, '<?php return [];');
        }

        $translations = require $filePath;

        // Check if the key exists, update or add the new translation
        $translations[$key] = $value;

        // Save the updated translations back to the file
        $phpContent = '<?php return ' . var_export($translations, true) . ';';
        File::put($filePath, $phpContent);
    }
}
