<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class TranslationService
{
    private const LANGUAGES = ['tr', 'en'];

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
        $filePath = lang_path("$lang/interface.php");

        // Ensure the file exists, if not create an empty one
        if (!File::exists($filePath)) {
            File::put($filePath, '<?php return [];');
        }

        // Load existing translations from the file
        $translations = require $filePath;

        // Handle dotted keys to place them inside nested arrays
        $this->setNestedArrayValue($translations, $key, $value);

        // Save the updated translations back to the file
        $phpContent = '<?php return ' . var_export($translations, true) . ';';
        File::put($filePath, $phpContent);
    }

    /**
     * Set a nested array value using "dot notation".
     *
     * @param array $array The array to update
     * @param string $key The dotted key (e.g., "cart.longList")
     * @param mixed $value The value to set
     */
    private function setNestedArrayValue(array &$array, string $key, $value): void
    {
        $keys = explode('.', $key);
        $current = &$array;

        foreach ($keys as $segment) {
            if (!isset($current[$segment]) || !is_array($current[$segment])) {
                $current[$segment] = [];
            }
            $current = &$current[$segment];
        }

        $current = $value;
    }

    public function removeTranslationKey(string $key): void
    {
        foreach (self::LANGUAGES as $lang) {
            $filePath = lang_path("$lang/interface.php");

            if (file_exists($filePath)) {
                // Load the current translations
                $translations = include $filePath;

                // Remove the key from the array
                $translations = $this->removeKeyFromArray($translations, $key);

                // Save the updated translations back to the file
                $this->writeToFile($filePath, $translations);
            }
        }
    }

    /**
     * Remove a key from a nested array.
     */
    protected function removeKeyFromArray(array $array, string $key): array
    {
        $keys = explode('.', $key);

        // If there are no keys left, return the array unchanged
        if (empty($keys)) {
            return $array;
        }

        // Get the first key in the chain
        $currentKey = array_shift($keys);

        // If the current key exists in the array
        if (isset($array[$currentKey])) {
            // If there are more keys to process, continue recursively
            if (!empty($keys)) {
                $array[$currentKey] = $this->removeKeyFromArray($array[$currentKey], implode('.', $keys));
            } else {
                // If this is the last key, remove it
                unset($array[$currentKey]);
            }
        }

        return $array;
    }

    /**
     * Write updated translations to the file.
     */
    protected function writeToFile(string $filePath, array $translations): void
    {
        $export = var_export($translations, true);
        file_put_contents($filePath, "<?php\n\nreturn $export;\n");
    }
}
