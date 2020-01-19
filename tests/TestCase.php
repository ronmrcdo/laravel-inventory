<?php

namespace Ronmrcdo\Inventory\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
	use DatabaseTransactions;

	protected function setUp(): void
    {
        parent::setUp();

		// Load the package factories
        $this->withFactories(__DIR__.'/../database/factories');
	}
}