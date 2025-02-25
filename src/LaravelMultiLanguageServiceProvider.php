<?php

namespace MichaelNabil230\LaravelMultiLanguage;

use MichaelNabil230\LaravelMultiLanguage\Commands\RouteTranslationsCacheCommand;
use MichaelNabil230\LaravelMultiLanguage\Commands\RouteTranslationsClearCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelMultiLanguageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-multi-language')
            ->hasConfigFile()
            ->hasCommands([
                RouteTranslationsCacheCommand::class,
                RouteTranslationsClearCommand::class,
            ]);
    }
}
