<?php namespace Ngmy\StandCi;
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

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Ngmy\StandCi\Repo\Build\BuildInterface;

class HousekeepCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'stand-ci:housekeep';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Discard the old Stand CI builds';

	protected $build;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(BuildInterface $build)
	{
		parent::__construct();

		$this->build = $build;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->info('Start housekeeping.');

		$maxBuilds = intval($this->option('max-builds'));

		$targetBuilds = $this->build->byGeneration($maxBuilds);

		foreach ($targetBuilds as $targetBuild) {
			$this->build->deleteById($targetBuild->id);
			File::deleteDirectory(public_path($targetBuild->artifact));
		}

		$this->info('Finish housekeeping.');
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
		return array(
			array('max-builds', null, InputOption::VALUE_REQUIRED, 'The maximum number of builds to keep.', Config::get('stand-ci::max_builds')),
		);
	}
}

