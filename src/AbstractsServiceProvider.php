<?php

namespace Hafael\Abstracts;

use Illuminate\Support\ServiceProvider;
use Hafael\Abstracts\Console\ResourceBootstrap;
use Hafael\Abstracts\Console\ModelBootstrap;
use Hafael\Abstracts\Console\ControllerBootstrap;
use Hafael\Abstracts\Console\EventBootstrap;
use Hafael\Abstracts\Console\JobBootstrap;
use Hafael\Abstracts\Console\PolicyBootstrap;
use Hafael\Abstracts\Console\RepositoryBootstrap;
use Hafael\Abstracts\Console\ServiceBootstrap;

class AbstractsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('command.abstracts:resource', ResourceBootstrap::class);
        $this->app->bind('command.abstracts:model', ModelBootstrap::class);
        $this->app->bind('command.abstracts:controller', ControllerBootstrap::class);
        $this->app->bind('command.abstracts:event', EventBootstrap::class);
        $this->app->bind('command.abstracts:job', JobBootstrap::class);
        $this->app->bind('command.abstracts:policy', PolicyBootstrap::class);
        $this->app->bind('command.abstracts:repository', RepositoryBootstrap::class);
        $this->app->bind('command.abstracts:service', ServiceBootstrap::class);

        $this->commands([
            'command.abstracts:resource',
            'command.abstracts:model',
            'command.abstracts:controller',
            'command.abstracts:event',
            'command.abstracts:job',
            'command.abstracts:policy',
            'command.abstracts:repository',
            'command.abstracts:service',
        ]);
    }
}
