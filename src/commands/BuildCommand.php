<?php namespace Ngmy\StandCi;
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

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use DateTime;
use Ngmy\StandCi\Repo\Build\BuildInterface;
use Ngmy\StandCi\Service\Lock\LockerInterface;
use Ngmy\StandCi\Service\Task\TaskContext;
use Ngmy\StandCi\Exception\StandCiException;

class BuildCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'stand-ci:build';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Run a Stand CI build.';

	protected $build;

	protected $locker;

	protected $taskContext;

	protected $taskStrategies;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(BuildInterface $build, LockerInterface $locker, TaskContext $taskContext, array $taskStrategies)
	{
		parent::__construct();

		$this->build = $build;

		$this->locker = $locker;

		$this->taskContext    = $taskContext;
		$this->taskStrategies = $taskStrategies;
	}

	/**
	 * Execute the console command.
	 *
	 * @throws Ngmy\StandCi\Exception\StandCiException;
	 * @return mixed
	 */
	public function fire()
	{
		if ($this->locker->isLock()) {
			return;
		}

		$id = md5(uniqid(rand(), true));

		$artifactPath = 'packages/ngmy/stand-ci/artifacts/'.$id;
		$outputDir    = storage_path().'/'.$artifactPath;

		$flag = true;

		// Lock
		$lockData['pid']      = getmypid();
		$lockData['build_id'] = $id;

		$this->locker->lock($lockData);

		// Start build
		File::makeDirectory($outputDir);

		$buildData['id']          = $id;
		$buildData['started_at']  = new DateTime;
		$buildData['finished_at'] = null;
		$buildData['status']      = BuildInterface::IN_PROCESS;
		$buildData['artifact']    = $artifactPath;

		$this->build->create($buildData);

		$this->info('Start build.');

		// Run tasks
		foreach ($this->taskStrategies as $taskName => $taskStrategy) {
			$this->info('Start '.$taskName.'.');

			$taskStrategy->outputDir($outputDir);
			$this->taskContext->strategy($taskStrategy);

			if ($this->taskContext->runTask() != 0) {
				$flag = false;
			}

			$this->info('Finish '.$taskName.'.');
		}

		// Closing process
		$buildData['id']          = $id;
		$buildData['finished_at'] = new DateTime;

		if ($flag) {
			$buildData['status'] = BuildInterface::SUCCESS;
		} else {
			$buildData['status'] = BuildInterface::FAILURE;
		}

		$this->build->update($buildData);

		// Unlock
		$this->locker->unlock();

		$this->info('Finish build.');

		// Send notification
		if (!$flag) {
			$url = URL::to(Config::get('stand-ci::route_prefix').'/builds/'.$id);

			throw new StandCiException("Build Failed.\n$url");
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}
}
