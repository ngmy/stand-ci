<?php namespace Ngmy\StandCi\Exception;
/**
 * Part of the StandCi package.
 *
 * Licensed under MIT License.
 *
 * @package    StandCi
 * @version    1.0.0
 * @author     Ngmy <y.nagamiya@gmail.com>
 * @license    http://opensource.org/licenses/MIT MIT License
 * @copyright  (c) 2015, Ngmy <y.nagamiya@gmail.com>
 * @link       https://github.com/ngmy/stand-ci
 */

use Ngmy\StandCi\Service\Notification\NotifierInterface;

class NotifyHandler implements HandlerInterface {

	protected $notifier;

	public function __construct(NotifierInterface $notifier)
	{
		$this->notifier = $notifier;
	}

	/**
	 * Handle StandCi Exceptions.
	 *
	 * @param StandCiException $exception StandCi Exception
	 * @return void
	 */
	public function handle(StandCiException $exception)
	{
		$this->sendException($exception);
	}

	/**
	 * Send Exception to notifier.
	 *
	 * @param \Exception $e Send notification of exception
	 * @return void
	 */
	protected function sendException(\Exception $e)
	{
		$this->notifier->notify('Error: '.get_class($e), $e->getMessage());
	}

}
