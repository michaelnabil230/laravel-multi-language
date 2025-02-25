<?php

namespace MichaelNabil230\LaravelMultiLanguage\Events;

class SetLocaleEvent
{
    public function __construct(public string $locale) {}
}
