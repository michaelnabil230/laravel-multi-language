<?php

namespace MichaelNabil230\LaravelMultiLanguage\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MichaelNabil230\LaravelMultiLanguage\LaravelMultiLanguage
 */
class LaravelMultiLanguage extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \MichaelNabil230\LaravelMultiLanguage\LaravelMultiLanguage::class;
    }
}
