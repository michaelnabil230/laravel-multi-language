<?php

namespace MichaelNabil230\LaravelMultiLanguage;

use MichaelNabil230\LaravelMultiLanguage\Facades\LaravelMultiLanguage;

class LanguageNegotiator
{
    /** @var list<string> */
    protected array $supportedLanguages;

    /**
     * Construct a new LanguageNegotiator instance.
     */
    public function __construct()
    {
        $this->supportedLanguages = LaravelMultiLanguage::getSupportedLanguagesKeys();
    }

    /**
     * Get the best matching language from the Accept-Language header.
     */
    public function getPreferredLanguage(string $acceptLanguageHeader): ?string
    {
        $languages = $this->parseAcceptLanguage($acceptLanguageHeader);

        foreach ($languages as $lang => $q) {
            // Direct match check.
            if (in_array($lang, $this->supportedLanguages, true)) {
                return $lang;
            }

            // Partial match check (e.g., "en-US" matches "en").
            if (mb_strpos($lang, '-') !== false) {
                $primary = explode('-', $lang)[0];
                if (in_array($primary, $this->supportedLanguages, true)) {
                    return $primary;
                }
            }
        }

        // Fallback: return the first supported language.
        return $this->supportedLanguages[0] ?? null;
    }

    /**
     * Parse the Accept-Language header into an array of language codes and their quality scores.
     *
     * @return array<string, float>
     */
    protected function parseAcceptLanguage(string $header): array
    {
        $languages = [];

        foreach (explode(',', $header) as $part) {
            $subParts = explode(';', trim($part));
            $lang = mb_strtolower(trim($subParts[0]));
            $q = 1.0;

            if (isset($subParts[1]) && mb_strpos($subParts[1], 'q=') !== false) {
                $q = (float) str_replace('q=', '', trim($subParts[1]));
            }

            $languages[$lang] = $q;
        }

        arsort($languages);

        return $languages;
    }
}
