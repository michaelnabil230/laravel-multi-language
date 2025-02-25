<?php

namespace MichaelNabil230\LaravelMultiLanguage\Tests;

use MichaelNabil230\LaravelMultiLanguage\LaravelMultiLanguageServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelMultiLanguageServiceProvider::class,
        ];
    }
}
