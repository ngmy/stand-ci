<?php namespace Ngmy\StandCi\Exception;
/**
 * Part of the StandCi package.
 *
 * Licensed under MIT License.
 *
 * @package    StandCi
 * @version    2.0.0
 * @author     Ngmy <y.nagamiya@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT License
 * @copyright  (c) 2015, Ngmy <y.nagamiya@gmail.com>
 * @link       https://github.com/ngmy/stand-ci
 */

use Ngmy\StandCi\Exception\NotifyHandler;
use Illuminate\Support\ServiceProvider;

class ExceptionServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$app = $this->app;

		$app->singleton(
			'Illuminate\Contracts\Debug\ExceptionHandler',
			'Ngmy\StandCi\StandCiExceptionHandler'
		);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$app = $this->app;

		$app['stand-ci.exception'] = $app->share(function ($app)
		{
			return new NotifyHandler($app['stand-ci.notifier']);
		});
	}

}
