<?php namespace Ngmy\StandCi;
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

use Ngmy\StandCi\Service\Task\TaskContext;
use Illuminate\Support\ServiceProvider;

class StandCiServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->bootConfig();
		$this->bootAsset();
		$this->bootView();
		$this->bootRoutes();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerServiceProviders();
		$this->registerCommands();
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

	/**
	 * Bootstrap the application config.
	 *
	 * @return void
	 */
	protected function bootConfig()
	{
		$this->publishes([
			__DIR__.'/../../config/config.php'       => config_path('packages/ngmy/stand-ci/ngmy-stand-ci.php'),
			__DIR__.'/../../config/notification.php' => config_path('packages/ngmy/stand-ci/ngmy-stand-ci-notification.php'),
			__DIR__.'/../../config/phpunit.xml.dist' => config_path('packages/ngmy/stand-ci/phpunit.xml.dist'),
		], 'config');

		$this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'ngmy-stand-ci');
		$this->mergeConfigFrom(__DIR__.'/../../config/notification.php', 'ngmy-stand-ci-notification');
	}

	/**
	 * Bootstrap the application asset.
	 *
	 * @return void
	 */
	protected function bootAsset()
	{
		$this->publishes([
			__DIR__.'/../../../public' => public_path('packages/ngmy/stand-ci'),
		], 'asset');
	}

	/**
	 * Bootstrap the application view.
	 *
	 * @return void
	 */
	protected function bootView()
	{
		$this->loadViewsFrom(__DIR__.'/../../views', 'stand-ci');
	}

	/**
	 * Bootstrap the application routes.
	 *
	 * @return void
	 */
	protected function bootRoutes()
	{
		$app = $this->app;

		if ($app['config']['ngmy-stand-ci']['publish_routes']) {
			include_once(__DIR__.'/../../routes.php');
		}
	}

	/**
	 * Register the package service providers.
	 *
	 * @return void
	 */
	protected function registerServiceProviders()
	{
		$app = $this->app;

		$app->register('Illuminate\Html\HtmlServiceProvider');

		$app->register('Ngmy\StandCi\Exception\ExceptionServiceProvider');
		$app->register('Ngmy\StandCi\Repo\RepoServiceProvider');
		$app->register('Ngmy\StandCi\Service\Lock\LockServiceProvider');
		$app->register('Ngmy\StandCi\Service\Notification\NotificationServiceProvider');
	}

	/**
	 * Register the artisan commands.
	 *
	 * @return void
	 */
	protected function registerCommands()
	{
		$app = $this->app;

		$app['command.stand-ci.install'] = $app->share(function ($app) {
			return new InstallCommand;
		});

		$app['command.stand-ci.build'] = $app->share(function ($app) {
			$config = $app['config'];

			$build  = $app->make('Ngmy\StandCi\Repo\Build\BuildInterface');
			$locker = $app->make('Ngmy\StandCi\Service\Lock\LockerInterface');

			foreach ($config['ngmy-stand-ci']['tasks'] as $name => $params) {
				$taskStrategy = new $params['strategy']($outputDir);

				$taskStrategy->failOnError($params['failonerror'])
					->executable($params['executable'])
					->extraArgs($params['extra_args']);

				$taskStrategies[$name] = $taskStrategy;
			}

			return new BuildCommand($build, $locker, new TaskContext, $taskStrategies);
		});

		$app['command.stand-ci.housekeep'] = $app->share(function ($app) {
			$build = $app->make('Ngmy\StandCi\Repo\Build\BuildInterface');

			return new HousekeepCommand($build);
		});

		$this->commands(array(
			'command.stand-ci.install',
			'command.stand-ci.build',
			'command.stand-ci.housekeep',
		));
	}

}
