<?php

namespace Ronmrcdo\Inventory\Tests;

use Ronmrcdo\Inventory\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

abstract class TestCase extends OrchestraTestCase
{
	use DatabaseTransactions;

	protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../database/factories');
	}
}