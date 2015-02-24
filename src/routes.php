<?php
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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

Route::group(array('prefix' => Config::get('stand-ci::route_prefix')), function() {
	Route::resource('builds', 'Ngmy\StandCi\BuildsController');
});
