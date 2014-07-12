<?php
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

return array(

	/*
	|--------------------------------------------------------------------------
	| Notification Driver
	|--------------------------------------------------------------------------
	|
	| This option controls the notification driver that will be utilized.
	|
	| Supported: "mail"
	|
	*/

	'notifier' => 'mail',

	/*
	|--------------------------------------------------------------------------
	| Sender And Receiver Settings
	|--------------------------------------------------------------------------
	|
	| Here you can set the settings for the sender and receiver.
	|
	*/

	'mail' => array(
		'from' => '',
		'to'   => '',
	),

	/*
	|--------------------------------------------------------------------------
	| Notification "Pretend"
	|--------------------------------------------------------------------------
	|
	| When this option is enabled, the notification will not actually be sent.
	|
	*/

	'pretend' => true,

);
