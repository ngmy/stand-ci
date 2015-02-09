<?php namespace Ngmy\StandCi\Library;
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

use Carbon\Carbon;

class StandCiCarbon extends Carbon {

	/**
	 * Get the difference in time in a human readable format.
	 *
	 * @param Carbon $other Carbon object
	 * @return string
	 */
	public function diffTimeForHumans(Carbon $other)
	{
		$diff = $this->diff($other);

		$h = $diff->h;
		$m = $diff->i;
		$s = $diff->s;

		$str = array();

		if ($h > 0) {
			$str[] = $h.' hour';
		}

		if ($m > 0) {
			$str[] = $m.' min';
		}

		if ($s > 0) {
			$str[] = $s.' sec';
		}

		return implode(' ', $str);
	}

}

