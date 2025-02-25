<?php

namespace MichaelNabil230\LaravelMultiLanguage\Commands;

use Illuminate\Console\Command;
use MichaelNabil230\LaravelMultiLanguage\Commands\Concerns\HandleTranslatedRoutes;

class RouteTranslationsClearCommand extends Command
{
    use HandleTranslatedRoutes;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'route:trans:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the translated route cache files for each locale.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->processLocalizedRoutes('route:clear');

        $this->components->info('Route caches for locales cleared.');
    }
}
