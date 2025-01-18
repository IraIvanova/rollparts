<?php

namespace Database\Seeders;

use App\Models\Translation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TranslationSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = lang_path('tr/interface.php');

        // Check if the file exists
        if (!File::exists($filePath)) {
            $this->command->error('Translation file not found: ' . $filePath);
            return;
        }

        // Load translations
        $translations = include $filePath;

        // Flatten translations for easier database insertion
        $flattenedTranslations = $this->flattenTranslations($translations);

        // Prepare data for bulk insertion
        $now = now();
        $data = [];
        foreach ($flattenedTranslations as $key => $value) {
            $data[] = [
                'key' => $key,
                'tr' => $value,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert into the database
        DB::table('translations')->insert($data);

        $this->command->info('Translations seeded successfully.');
    }

    /**
     * Recursively flatten a nested array of translations.
     */
    protected function flattenTranslations(array $translations, string $prefix = ''): array
    {
        $result = [];

        foreach ($translations as $key => $value) {
            $fullKey = $prefix ? $prefix . '.' . $key : $key;

            if (is_array($value)) {
                // Recurse into sub-arrays
                $result = array_merge($result, $this->flattenTranslations($value, $fullKey));
            } else {
                // Add the translation to the result
                $result[$fullKey] = $value;
            }
        }

        return $result;
    }
}
