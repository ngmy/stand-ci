<?php namespace Ngmy\StandCi;
/**
 * Part of the StandCi package.
 *
 * Licensed under MIT License.
 *
 * @package    StandCi
 * @version    0.1.0
 * @author     Ngmy <y.nagamiya@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT License
 * @copyright  (c) 2015, Ngmy <y.nagamiya@gmail.com>
 * @link       https://github.com/ngmy/stand-ci
 */

use Ngmy\StandCi\Build;
use Ngmy\StandCi\Repo\Build\FileBuild;
use Ngmy\StandCi\Service\Lock\FileLocker;
use Ngmy\StandCi\Service\Task\TaskContext;
use Ngmy\StandCi\Service\Notification\MailNotifier;
use Ngmy\StandCi\Exception\StandCiException;
use Ngmy\StandCi\Exception\NotifyHandler;
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
		$this->package('ngmy/stand-ci', 'stand-ci');

		$this->bootRoutes();
		$this->bootException();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerCommands();
		$this->registerRepo();
		$this->registerException();
		$this->registerLocker();
		$this->registerNotifier();
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
	 * Bootstrap the application routes.
	 *
	 * @return void
	 */
	protected function bootRoutes()
	{
		$app = $this->app;

		if ($app['config']->get('stand-ci::publish_routes')) {
			include_once(__DIR__ . '/../../routes.php');
		}
	}

	/**
	 * Bootstrap the application exceptions.
	 *
	 * @return void
	 */
	protected function bootException()
	{
		$app = $this->app;

		$app->error(function(StandCiException $e) use ($app)
		{
			$app['stand-ci.exception']->handle($e);
		});
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

			foreach ($config['stand-ci::tasks'] as $name => $params) {
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

	/**
	 * Register the application repositories.
	 *
	 * @return void
	 */
	protected function registerRepo()
	{
		$this->app->bind('Ngmy\StandCi\Repo\Build\BuildInterface', function ($app) {
			$directory = storage_path().'/packages/ngmy/stand-ci/builds';

			return new FileBuild($directory);
		});
	}

	/**
	 * Register the application exceptions.
	 *
	 * @return void
	 */
	protected function registerException()
	{
		$app = $this->app;

		$app['stand-ci.exception'] = $app->share(function ($app)
		{
			return new NotifyHandler($app['stand-ci.notifier']);
		});
	}

	/**
	 * Register the service provider of the lock service.
	 *
	 * @return void
	 */
	protected function registerLocker()
	{
		$app = $this->app;

		$app['stand-ci.locker'] = $app->share(function ($app)
		{
			$config = $app['config'];

			$locker = $app->make('Ngmy\StandCi\Service\Lock\LockerInterface');

			return $locker;
		});

		$app->bind('Ngmy\StandCi\Service\Lock\LockerInterface', function ($app) {
			$lockFile = storage_path().'/packages/ngmy/stand-ci/lock.json';

			return new FileLocker($lockFile);
		});
	}

	/**
	 * Register the service provider of the notification service.
	 *
	 * @return void
	 */
	protected function registerNotifier()
	{
		$app = $this->app;

		$app['stand-ci.notifier'] = $app->share(function ($app)
		{
			$config = $app['config'];

			if ($config['stand-ci::notification.pretend']) {
				return null;
			}

			if ($config['stand-ci::notification.notifier'] === 'mail') {
				$notifier = new MailNotifier;

				$notifier->from($config['stand-ci::notification.mail.from'])->to($config['stand-ci::notification.mail.to']);

				return $notifier;
			}
		});
	}

}
