<?php

namespace Ronmrcdo\Inventory\Tests;

use Illuminate\Support\Str;
use Ronmrcdo\Inventory\Models\Product;
use Ronmrcdo\Inventory\Models\Attribute;
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

    /**
     * Create a test product with variation
     */
    protected function createTestProduct()
    {
        $product = factory(Product::class)->create();

		$sizeAttr = factory(Attribute::class)->make([
			'name' => 'size'
		]);
		$sizeTerms = ['small', 'medium', 'large'];
		$colorAttr = factory(Attribute::class)->make([
			'name' => 'color'
		]);
		$colorTerm = ['black', 'white'];

		// Set the terms and attributes
		$product->addAttribute($sizeAttr->name);
		$product->addAttribute($colorAttr->name);
		$product->addAttributeTerm($sizeAttr->name, $sizeTerms);
		$product->addAttributeTerm($colorAttr->name, $colorTerm);
		
		$variantSmallBlack = [
			'sku' => Str::random(16),
			'price' => rand(100,300),
			'cost' => rand(50, 99),
			'variation' => [
				['option' => 'color', 'value' => 'black'],
				['option' => 'size', 'value' => 'small'],
			]
		];
		$variantSmallWhite = [
			'sku' => Str::random(16),
			'price' => rand(100,300),
			'cost' => rand(50, 99),
			'variation' => [
				['option' => 'color', 'value' => 'white'],
				['option' => 'size', 'value' => 'small'],
			]
		];
		$product->addVariant($variantSmallBlack);
		$product->addVariant($variantSmallWhite);

		return $product;
    }
}