<?php namespace Ngmy\StandCi\Service\Lock;
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

use Ngmy\StandCi\Service\Lock\FileLocker;
use Illuminate\Support\ServiceProvider;

class LockServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$app = $this->app;

		$app['stand-ci.locker'] = $app->share(function ($app)
		{
			$config = $app['config'];

			$locker = $app->make('Ngmy\StandCi\Service\Lock\LockerInterface');

			return $locker;
		});

		$app->bind('Ngmy\StandCi\Service\Lock\LockerInterface', function ($app) {
			$lockFile = storage_path('packages/ngmy/stand-ci/lock.json');

			return new FileLocker($lockFile);
		});
	}

}
