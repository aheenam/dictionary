<?php

namespace Aheenam\Dictionary;

use Illuminate\Support\ServiceProvider;

class DictionaryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
    	$this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');

	    $this->publishes([
		    __DIR__.'/../config/dictionary.php' => config_path('dictionary.php'),
	    ], "config");

    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
	    $this->mergeConfigFrom(
		    __DIR__.'/../config/dictionary.php', 'dictionary'
	    );
    }
}