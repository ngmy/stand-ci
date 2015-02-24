<?php namespace Ngmy\StandCi\Service\Task;
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

class TaskContext {

	protected $strategy;

	/**
	 * Strategy of task.
	 *
	 * @param Ngmy\StandCi\Service\Task\TaskStrategyInterface $strategy The strategy
	 * @return void
	 */
	public function strategy(TaskStrategyInterface $strategy)
	{
		$this->strategy = $strategy;
	}

	public function runTask()
	{
		$status = $this->strategy->process();

		$this->strategy->output();

		$this->strategy->outputOverview();

		return $status;
	}

}
