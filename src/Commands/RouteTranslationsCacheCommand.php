<?php

namespace MichaelNabil230\LaravelMultiLanguage\Commands;

use Illuminate\Console\Command;
use MichaelNabil230\LaravelMultiLanguage\Commands\Concerns\HandleTranslatedRoutes;

class RouteTranslationsCacheCommand extends Command
{
    use HandleTranslatedRoutes;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'route:trans:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a route cache file for faster route registration for all locales.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->processLocalizedRoutes('route:cache');

        $this->components->info('Routes cached successfully for all locales.');
    }
}
