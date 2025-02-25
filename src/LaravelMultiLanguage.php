<?php

namespace MichaelNabil230\LaravelMultiLanguage;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Env;
use Illuminate\Support\Uri;
use InvalidArgumentException;

class LaravelMultiLanguage
{
    /**
     * Environment variable key for a forced routing locale.
     */
    public const ENV_ROUTE_KEY = 'ROUTING_LOCALE';

    /**
     * Construct a new Localization instance.
     */
    public function __construct(
        protected Application $app,
        protected Request $request,
        protected Repository $config,
    ) {}

    /**
     * Get the locale prefix.
     *
     * If no locale is provided, it attempts to use the first URI segment or a forced locale.
     */
    public function prefix(?string $locale = null): string
    {
        if (empty($locale)) {
            $locale = $this->request->segment(1) ?: $this->getForcedLocale();
        }

        return $this->isSupportedLocale($locale) ? $locale : '';
    }

    /**
     * Get the path to the cached routes file for a given locale.
     */
    public function cachedRoutesPath(?string $locale = null): string
    {
        if (! $locale || ! $this->isSupportedLocale($locale)) {
            return $this->app->getCachedRoutesPath();
        }

        return $this->app->bootstrapPath("cache/routes-v7-{$locale}.php");
    }

    /**
     * Check if a locale is supported.
     */
    public function isSupportedLocale(?string $locale): bool
    {
        return in_array($locale, $this->getSupportedLanguagesKeys());
    }

    /**
     * Throw an exception if the locale is not supported.
     */
    public function throwIfNotSupportedLocale(?string $locale): void
    {
        if (! $this->isSupportedLocale($locale)) {
            throw new InvalidArgumentException('The locale is not a supported.');
        }
    }

    /**
     * Retrieve the script for the current locale.
     *
     * The script can be used to determine the writing system (e.g., 'Arab', 'Latn').
     */
    public function getCurrentLocaleScript(): string
    {
        return Arr::get($this->getSupportedLocales(), $this->getCurrentLocale().'.script');
    }

    /**
     * Get the text direction for the current locale.
     *
     * Returns 'rtl' for right-to-left scripts and 'ltr' for left-to-right.
     */
    public function getCurrentLocaleDirection(): string
    {
        return match ($this->getCurrentLocaleScript()) {
            'Arab', 'Hebr', 'Mong', 'Tfng', 'Thaa' => 'rtl',
            default => 'ltr',
        };
    }

    /**
     * Retrieve the current application locale.
     */
    public function getCurrentLocale(): string
    {
        return $this->app->getLocale();
    }

    /**
     * Get the array of fallback locale from configuration.
     */
    public function getFallbackLocale(): string
    {
        return $this->config->string('multi-language.fallback_locale');
    }

    /**
     * Get the array of supported locales from configuration.
     */
    public function getSupportedLocales(): array
    {
        return $this->config->array('multi-language.supportedLocales');
    }

    /**
     * Get the array of supported locales keys from configuration.
     */
    public function getSupportedLanguagesKeys(): array
    {
        return array_keys($this->getSupportedLocales());
    }

    /**
     * Generate a localized URL by replacing the current locale in the URL segments.
     *
     * If a URI is provided, it processes that URI; otherwise, it uses the current request's segments.
     */
    public function getLocalizedURL(string $locale, ?string $uri = null): string
    {
        $this->throwIfNotSupportedLocale($locale);

        if ($uri) {
            $uri = Uri::of($uri);
            $segments = array_values(array_filter(
                explode('/', $uri->path().$uri->query()),
                fn ($value) => $value !== ''
            ));
        } else {
            $segments = $this->request->segments();
        }

        $currentLocale = $this->getCurrentLocale();

        $localizedPath = collect($segments)
            ->map(fn ($value) => $value === $currentLocale ? $locale : $value)
            ->implode('/');

        return rtrim($this->config->string('app.url'), '/').'/'.$localizedPath;
    }

    /**
     * Retrieve the forced locale from the environment variable.
     */
    protected function getForcedLocale(): ?string
    {
        return Env::getRepository()->get(self::ENV_ROUTE_KEY);
    }

    /**
     * Set the forced locale in the environment variable.
     */
    public function setForcedLocale(string $locale): void
    {
        Env::getRepository()->set(self::ENV_ROUTE_KEY, $locale);
    }
}
