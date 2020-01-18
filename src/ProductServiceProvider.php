<?php

namespace Ronmrcdo\Inventory;

use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
	/**
	 * Boot the configurations
	 * 
	 * @return void
	 */
	public function boot(): void
	{
		// Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
	}

	/**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['inventory'];
    }

	/**
	 * Register the bootable configurations
	 * 
	 * @return void
	 */
	protected function bootForConsole(): void
	{
		$this->loadMigrationsFrom(__DIR__.'/../database/migrations');

		$this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations')
        ], 'inventory.migrations');
	}
}