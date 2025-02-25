<?php

namespace MichaelNabil230\LaravelMultiLanguage;

use Illuminate\Support\Facades\Log;
use MichaelNabil230\LaravelMultiLanguage\Facades\LaravelMultiLanguage;

trait LoadsTranslatedCachedRoutes
{
    /**
     * Load the cached routes for the application.
     */
    protected function loadCachedRoutes(): void
    {
        $locale = LaravelMultiLanguage::prefix();

        $path = LaravelMultiLanguage::cachedRoutesPath($locale);

        if (! file_exists($path)) {
            Log::warning("The cached routes not found for locale '{$locale}'.");

            $path = app()->getCachedRoutesPath();
        }

        $this->app->booted(fn (): mixed => require $path);
    }
}
