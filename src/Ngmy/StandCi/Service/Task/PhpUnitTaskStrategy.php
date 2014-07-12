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

use Illuminate\Support\Facades\File;
use DomDocument;
use XSLTProcessor;

class PhpUnitTaskStrategy implements TaskStrategyInterface {

	protected $outputDir;

	protected $failOnError;

	protected $executable;

	protected $extraArgs;

	public function outputDir($outputDir)
	{
		$this->outputDir = $outputDir;

		return $this;
	}

	public function failOnError($failOnError)
	{
		$this->failOnError = $failOnError;

		return $this;
	}

	public function executable($executable)
	{
		$this->executable = $executable;

		return $this;
	}

	public function extraArgs($extraArgs)
	{
		$this->extraArgs = $extraArgs;

		return $this;
	}

	public function process()
	{
		$commands[] = 'cd '.base_path();
		$commands[] = $this->executable.' '.$this->extraArgs.' --log-junit '.$this->outputDir.'/logs/phpunit.xml --coverage-html '.$this->outputDir.'/coverage --coverage-clover '.$this->outputDir.'/logs/clover.xml';

		$command = implode(';', $commands);

		system($command, $status);

		if ($this->failOnError) {
			return $status;
		} else {
			return 0;
		}
	}

	public function output()
	{
		$xml = new DomDocument;
		$xml->load($this->outputDir.'/logs/phpunit.xml');

		$xsl = new DomDocument;
		$xsl->load(public_path().'/packages/ngmy/stand-ci/xsl/phpunit.xsl');

		$processor = new XSLTProcessor;
		$processor->importStyleSheet($xsl);

		File::put($this->outputDir.'/phpunit.html', $processor->transformToXML($xml));
	}

	public function outputOverview()
	{
		$xml = new DomDocument;
		$xml->load($this->outputDir.'/logs/phpunit.xml');

		$xsl = new DomDocument;
		$xsl->load(public_path().'/packages/ngmy/stand-ci/xsl/phpunit_overview.xsl');

		$processor = new XSLTProcessor;
		$processor->importStyleSheet($xsl);

		File::put($this->outputDir.'/phpunit_overview.html', $processor->transformToXML($xml));
	}

}
