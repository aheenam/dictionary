<?php

namespace Aheenam\Dictionary\Test;

use Aheenam\Dictionary\DictionaryServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{

	/**
	 * Setup the test environment.
	 */
	public function setUp()
	{
		parent::setUp();
		$this->withFactories(__DIR__ . '/../database/factories');
	}

	/**
	 * add the package provider
	 *
	 * @param $app
	 * @return array
	 */
	protected function getPackageProviders($app)
	{
		return [DictionaryServiceProvider::class];
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