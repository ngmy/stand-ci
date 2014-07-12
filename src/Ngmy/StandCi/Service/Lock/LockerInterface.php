<?php namespace Ngmy\StandCi\Service\Lock;
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

interface LockerInterface {

	/**
	 * Lock the process.
	 *
	 * @param array $data Data to lock the process
	 * @return void
	 */
	public function lock(array $data);

	/**
	 * Unlock the process.
	 *
	 * @return void
	 */
	public function unlock();

	/**
	 * Check if the process is locked.
	 *
	 * @return boolean
	 */
	public function isLock();

}
