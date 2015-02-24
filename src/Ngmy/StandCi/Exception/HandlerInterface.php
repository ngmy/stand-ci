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

interface HandlerInterface {

	/**
	 * Handle StandCi Exceptions.
	 *
	 * @param StandCiException $exception StandCi Exception
	 * @return void
	 */
	public function handle(StandCiException $exception);

}
