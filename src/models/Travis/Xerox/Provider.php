<?php

namespace Travis\Xerox;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider {

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $dir = __DIR__.'/../../../';

        // public config
        $this->publishes([
            $dir.'config/xerox.php' => config_path('xerox.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}