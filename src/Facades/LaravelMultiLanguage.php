<?php

namespace MichaelNabil230\LaravelMultiLanguage\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string prefix(string|null $locale = null)
 * @method static string cachedRoutesPath(string|null $locale = null)
 * @method static bool isSupportedLocale(string|null $locale)
 * @method static void throwIfNotSupportedLocale(string|null $locale)
 * @method static string getCurrentLocaleScript()
 * @method static string getCurrentLocaleDirection()
 * @method static string getCurrentLocale()
 * @method static string getFallbackLocale()
 * @method static array getSupportedLocales()
 * @method static array getSupportedLanguagesKeys()
 * @method static string getLocalizedURL(string $locale, string|null $uri = null)
 * @method static void setForcedLocale(string $locale)
 *
 * @see \MichaelNabil230\LaravelMultiLanguage\LaravelMultiLanguage
 */
class LaravelMultiLanguage extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \MichaelNabil230\LaravelMultiLanguage\LaravelMultiLanguage::class;
    }
}
