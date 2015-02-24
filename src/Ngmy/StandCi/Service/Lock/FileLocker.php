<?php namespace Ngmy\StandCi\Service\Lock;
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

use Illuminate\Support\Facades\File;

class FileLocker implements LockerInterface {

	/**
	 * Path of lock file
	 *
	 * @var string
	 */
	protected $lockFile;

	public function __construct($lockFile)
	{
		$this->lockFile = $lockFile;
	}

	/**
	 * Lock the process
	 *
	 * @param array $data Data to lock the process
	 * @return void
	 */
	public function lock(array $data)
	{
		File::put($this->lockFile, json_encode($data, JSON_PRETTY_PRINT));
	}

	/**
	 * Unlock the process
	 *
	 * @return void
	 */
	public function unlock()
	{
		File::delete($this->lockFile);
	}

	/**
	 * Check if the process is locked.
	 *
	 * @return boolean
	 */
	public function isLock()
	{
		if (File::exists($this->lockFile)) {
			$json = File::get($this->lockFile);
			$lock = json_decode($json, true);

			system('ps ho pid p '.$lock['pid'].' > /dev/null', $status);

			if ($status) {
				$this->unlock();
				return false;
			} else {
				return true;
			}
		}

		return false;
	}

}
