<?php namespace Ngmy\StandCi;
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

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InstallCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'stand-ci:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Install Stand CI.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->createStorageDirectory();
		$this->publishAsset();
		$this->publishConfig();
	}

	protected function createStorageDirectory()
	{
		$rootDirectory      = storage_path('packages/ngmy/stand-ci');
		$buildsDirectory    = $rootDirectory.'/builds';
		$artifactsDirectory = $rootDirectory.'/artifacts';

		$commands[] = 'mkdir -m 777 -p '.$rootDirectory;
		$commands[] = 'mkdir -m 777 -p '.$buildsDirectory;
		$commands[] = 'mkdir -m 777 -p '.$artifactsDirectory;

		$command = implode(';', $commands);

		system($command, $status);

		$this->info('Storage directories created');
	}

	protected function publishAsset()
	{
		$this->call('vendor:publish', [
			'--provider' => 'Ngmy\StandCi\StandCiServiceProvider',
			'--tag'      => 'asset',
		]);

		$commands[] = 'cd '.public_path('packages/ngmy/stand-ci');
		$commands[] = 'ln -nfs '.storage_path('packages/ngmy/stand-ci/artifacts').' artifacts';

		$command = implode(';', $commands);

		system($command, $status);

	}

	protected function publishConfig()
	{
		$this->call('vendor:publish', [
			'--provider' => 'Ngmy\StandCi\StandCiServiceProvider',
			'--tag'      => 'config',
		]);
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
