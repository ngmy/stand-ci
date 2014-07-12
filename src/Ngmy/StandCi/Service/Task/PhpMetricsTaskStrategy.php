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

class PhpMetricsTaskStrategy implements TaskStrategyInterface {

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
		$commands[] = $this->executable.' --report-json='.$this->outputDir.'/logs/phpmetrics.json app';

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
		$contents = File::get($this->outputDir.'/logs/phpmetrics.json');

		$results = json_decode($contents);

		$html = <<<HTML
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8"/>
    <title>PHPMetrics</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/packages/ngmy/stand-ci/css/iframe.css"/>
  </head>
  <body>
    <div class="container">
      <table class="table">
        <thead>
          <tr>
            <th><div align="center">File</div></th>
            <th><div align="center"><abbr title="Lines of Code">LOC</abbr></div></th>
            <th><div align="center"><abbr title="Logical Lines of Code">LLOC</abbr></div></th>
            <th><div align="center"><abbr title="Comment Weight">CommW</abbr></div></th>
            <th><div align="center"><abbr title="Cyclomatic Complexity">CC</abbr></div></th>
            <th><div align="center"><abbr title="Maintenability Index">MI</abbr></div></th>
            <th><div align="center"><abbr title="Instability">Inst.</abbr></div></th>
            <th><div align="center"><abbr title="Afferent Coupling">CA</abbr></div></th>
            <th><div align="center"><abbr title="Efferent Coupling">CE</abbr></div></th>
          </tr>
        </thead>
        <tbody>
          %s
        </tbody>
      </table>
    </div>
  </body>
</html>
HTML;

		$tbody = '';

		foreach ($results as $result) {
			$filename             = $result->filename;
			$loc                  = $result->loc;
			$logicalLoc           = $result->logicalLoc;
			$commentWeight        = $result->commentWeight;
			$cyclomaticComplexity = $result->cyclomaticComplexity;
			$maintenabilityIndex  = $result->maintenabilityIndex;
			$instability          = $result->instability;
			$afferentCoupling     = $result->afferentCoupling;
			$efferentCoupling     = $result->efferentCoupling;

			$tbody .= '<tr>';
			$tbody .= '<td>'.$filename.'</td>';
			$tbody .= '<td><div class="text-right">'.$loc.'</div></td>';
			$tbody .= '<td><div class="text-right">'.$logicalLoc.'</div></td>';
			$tbody .= $this->createCommentWeightTag($commentWeight);
			$tbody .= $this->createCyclomaticComplexityTag($cyclomaticComplexity);
			$tbody .= $this->createMaintenabilityIndexTag($maintenabilityIndex);
			$tbody .= $this->createInstabilityTag($instability);
			$tbody .= $this->createAfferentCouplingTag($afferentCoupling);
			$tbody .= $this->createEfferentCouplingTag($efferentCoupling);
			$tbody .= '<tr>';
		}

		$html = sprintf($html, $tbody);

		File::put($this->outputDir.'/metrics.html', $html);
	}

	public function outputOverview()
	{
	}

	protected function createCommentWeightTag($commentWeight)
	{
		if ($commentWeight < 36) {
			$tag = '<td><div class="text-right"><span class="hatching hatching-critical">'.$commentWeight.'</span></div></td>';
		} elseif ($commentWeight < 38) {
			$tag = '<td><div class="text-right"><span class="hatching hatching-warning">'.$commentWeight.'</span></div></td>';
		} elseif ($commentWeight < 41) {
			$tag = '<td><div class="text-right">'.$commentWeight.'</div></td>';
		} else {
			$tag = '<td><div class="text-right"><span class="hatching hatching-good">'.$commentWeight.'</span></div></td>';
		}

		return $tag;
	}

	protected function createCyclomaticComplexityTag($cyclomaticComplexity)
	{
		if ($cyclomaticComplexity > 10) {
			$tag = '<td><div class="text-right"><span class="hatching hatching-critical">'.$cyclomaticComplexity.'</span></div></td>';
		} elseif ($cyclomaticComplexity > 6) {
			$tag = '<td><div class="text-right"><span class="hatching hatching-warning">'.$cyclomaticComplexity.'</span></div></td>';
		} elseif ($cyclomaticComplexity > 2) {
			$tag = '<td><div class="text-right">'.$cyclomaticComplexity.'</div></td>';
		} else {
			$tag = '<td><div class="text-right"><span class="hatching hatching-good">'.$cyclomaticComplexity.'</span></div></td>';
		}

		return $tag;
	}

	protected function createMaintenabilityIndexTag($maintenabilityIndex)
	{
		if ($maintenabilityIndex < 0) {
			$tag = '<td><div class="text-right"><span class="hatching hatching-critical">'.$maintenabilityIndex.'</span></div></td>';
		} elseif ($maintenabilityIndex < 69) {
			$tag = '<td><div class="text-right"><span class="hatching hatching-warning">'.$maintenabilityIndex.'</span></div></td>';
		} elseif ($maintenabilityIndex < 85) {
			$tag = '<td><div class="text-right">'.$maintenabilityIndex.'</div></td>';
		} else {
			$tag = '<td><div class="text-right"><span class="hatching hatching-good">'.$maintenabilityIndex.'</span></div></td>';
		}

		return $tag;
	}

	protected function createInstabilityTag($instability)
	{
		if ($instability > 1) {
			$tag = '<td><div class="text-right"><span class="hatching hatching-critical">'.$instability.'</span></div></td>';
		} elseif ($instability > 0.95) {
			$tag = '<td><div class="text-right"><span class="hatching hatching-warning">'.$instability.'</span></div></td>';
		} elseif ($instability > 0.45) {
			$tag = '<td><div class="text-right">'.$instability.'</div></td>';
		} else {
			$tag = '<td><div class="text-right"><span class="hatching hatching-good">'.$instability.'</span></div></td>';
		}

		return $tag;
	}

	protected function createAfferentCouplingTag($afferentCoupling)
	{
		if ($afferentCoupling > 20) {
			$tag = '<td><div class="text-right"><span class="hatching hatching-critical">'.$afferentCoupling.'</span></div></td>';
		} elseif ($afferentCoupling > 15) {
			$tag = '<td><div class="text-right"><span class="hatching hatching-warning">'.$afferentCoupling.'</span></div></td>';
		} elseif ($afferentCoupling > 9) {
			$tag = '<td><div class="text-right">'.$afferentCoupling.'</div></td>';
		} else {
			$tag = '<td><div class="text-right"><span class="hatching hatching-good">'.$afferentCoupling.'</span></div></td>';
		}

		return $tag;
	}

	protected function createEfferentCouplingTag($efferentCoupling)
	{
		if ($efferentCoupling > 15) {
			$tag = '<td><div class="text-right"><span class="hatching hatching-critical">'.$efferentCoupling.'</span></div></td>';
		} elseif ($efferentCoupling > 11) {
			$tag = '<td><div class="text-right"><span class="hatching hatching-warning">'.$efferentCoupling.'</span></div></td>';
		} elseif ($efferentCoupling > 7) {
			$tag = '<td><div class="text-right">'.$efferentCoupling.'</div></td>';
		} else {
			$tag = '<td><div class="text-right"><span class="hatching hatching-good">'.$efferentCoupling.'</span></div></td>';
		}

		return $tag;
	}

}
