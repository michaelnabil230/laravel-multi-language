<?php

namespace MichaelNabil230\LaravelMultiLanguage\Commands;

use Illuminate\Console\Command;

class LaravelMultiLanguageCommand extends Command
{
    public $signature = 'laravel-multi-language';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
