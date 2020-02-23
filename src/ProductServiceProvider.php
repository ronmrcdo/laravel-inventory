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
	 * Register the configurations
	 * 
	 * @return void
	 */
	public function register(): void
	{
		$this->mergeConfigFrom(__DIR__.'/../config/laravel-inventory.php', 'laravel-inventory');
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
		$this->publishes([
            __DIR__.'/../config/laravel-inventory.php' => base_path('config/laravel-inventory.php'),
		], 'config');
		
		$this->loadMigrationsFrom(__DIR__.'/../database/migrations');

		$this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations')
        ], 'migrations');
	}
}