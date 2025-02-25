<?php

namespace MichaelNabil230\LaravelMultiLanguage\Commands\Concerns;

use Illuminate\Support\Env;
use MichaelNabil230\LaravelMultiLanguage\Facades\LaravelMultiLanguage;

trait HandleTranslatedRoutes
{
    /**
     * Process the routes for each supported locale.
     */
    protected function processLocalizedRoutes(string $command): void
    {
        $supportedLocales = [null, ...LaravelMultiLanguage::getSupportedLanguagesKeys()];

        foreach ($supportedLocales as $locale) {
            $this->setEnvironmentVariables($locale);
            $this->callSilent($command);
            $this->resetEnvironmentVariable($locale);
        }
    }

    /**
     * Set environment variables for route processing.
     */
    protected function setEnvironmentVariables(?string $locale): void
    {
        if ($locale !== null) {
            LaravelMultiLanguage::setForcedLocale($locale);
        }

        Env::getRepository()->set('APP_ROUTES_CACHE', LaravelMultiLanguage::cachedRoutesPath($locale));
    }

    /**
     * Reset the environment variable after processing.
     */
    protected function resetEnvironmentVariable(?string $locale): void
    {
        if ($locale !== null) {
            LaravelMultiLanguage::setForcedLocale('');
        }
    }
}
