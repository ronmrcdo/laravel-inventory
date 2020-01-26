<?php

namespace Ronmrcdo\Inventory\Tests;

use Ronmrcdo\Inventory\ProductServiceProvider;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
	use DatabaseTransactions;

	protected function setUp(): void
    {
		parent::setUp();

		// Load the package factories
		$this->withFactories(__DIR__.'/../database/factories');

		$this->artisan('migrate', 
                      ['--database' => 'testing'])->run();
	}

	/**
     * add the package provider
     *
     * @param $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [ProductServiceProvider::class];
	}
	
	/**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}