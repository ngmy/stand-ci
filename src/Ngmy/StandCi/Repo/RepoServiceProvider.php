<?php namespace Ngmy\StandCi\Repo;
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

use Ngmy\StandCi\Repo\Build\FileBuild;
use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$app = $this->app;

		$app->bind('Ngmy\StandCi\Repo\Build\BuildInterface', function ($app) {
			$directory = storage_path('packages/ngmy/stand-ci/builds');

			return new FileBuild($directory);
		});
	}

}
