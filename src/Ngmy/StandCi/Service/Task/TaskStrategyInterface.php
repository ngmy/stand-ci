<?php namespace Ngmy\StandCi\Service\Task;
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

interface TaskStrategyInterface {

	public function outputDir($outputDir);

	public function failOnError($failOnError);

	public function executable($executable);

	public function extraArgs($extraArgs);

	public function process();

	public function output();

	public function outputOverview();

}
