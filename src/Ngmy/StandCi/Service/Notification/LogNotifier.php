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

use Illuminate\Support\Facades\Log;

class LogNotifier implements NotifierInterface {

	/**
	 * Recipient of notification.
	 *
	 * @var string
	 */
	protected $to;

	/**
	 * Sender of notification.
	 *
	 * @var string
	 */
	protected $from;

	/**
	 * Recipients of notification.
	 *
	 * @param string $to The recipient
	 * @return Ngmy\StandCi\Service\Notification\NotifierInterface Return self for chainability
	 */
	public function to($to)
	{
		$this->to = $to;

		return $this;
	}

	/**
	 * Sender of notification.
	 *
	 * @param string $from The sender
	 * @return Ngmy\StandCi\Service\Notification\NotifierInterface Return self for chainability
	 */
	public function from($from)
	{
		$this->from = $from;

		return $this;
	}

	/**
	 * Send notification.
	 *
	 * @param string $subject The subject of notification
	 * @param string $message The message of notification
	 * @return void
	 */
	public function notify($subject, $message)
	{
		Log::error($subject."\n".$message);
	}

}

