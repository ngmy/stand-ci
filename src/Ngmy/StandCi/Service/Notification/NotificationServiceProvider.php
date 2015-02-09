<?php namespace Ngmy\StandCi\Service\Notification;
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

use Ngmy\StandCi\Service\Notification\LogNotifier;
use Ngmy\StandCi\Service\Notification\MailNotifier;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$app = $this->app;

		$app['stand-ci.notifier'] = $app->share(function ($app)
		{
			$config = $app['config'];

			if ($config['ngmy-stand-ci-notification']['pretend']) {
				$notifier = new LogNotifier;

				return $notifier;
			}

			if ($config['ngmy-stand-ci-notification']['notifier'] === 'mail') {
				$notifier = new MailNotifier;

				$notifier->from($config['ngmy-stand-ci-notification']['mail']['from'])
					->to($config['ngmy-stand-ci-notification']['mail']['to']);

				return $notifier;
			}
		});
	}

}
