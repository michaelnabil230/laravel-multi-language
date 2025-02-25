<?php

namespace MichaelNabil230\LaravelMultiLanguage;

use MichaelNabil230\LaravelMultiLanguage\Commands\LaravelMultiLanguageCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelMultiLanguageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-multi-language')
            ->hasConfigFile()
            ->hasCommand(LaravelMultiLanguageCommand::class);
    }
}
