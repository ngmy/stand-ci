<?php namespace Ngmy\StandCi\Service\Notification;
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

interface NotifierInterface {

	/**
	 * Recipient of notification.
	 *
	 * @var string
	 */
	public function to($to);

	/**
	 * Sender of notification.
	 *
	 * @param string $from The sender
	 * @return Ngmy\StandCi\Service\Notification\NotifierInterface Return self for chainability
	 */
	public function from($from);

	/**
	 * Send notification.
	 *
	 * @param string $subject The subject of notification
	 * @param string $message The message of notification
	 * @return void
	 */
	public function notify($subject, $message);

}
