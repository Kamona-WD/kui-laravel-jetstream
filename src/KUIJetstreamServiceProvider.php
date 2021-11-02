<?php

namespace KUI\Jetstream;

use Illuminate\Support\ServiceProvider;

class KUIJetstreamServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Console\ReplaceCommand::class,
        ]);
    }

    public function register()
    {
        //
    }
}
