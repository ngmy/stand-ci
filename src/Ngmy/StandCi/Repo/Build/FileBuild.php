<?php namespace Ngmy\StandCi\Repo\Build;
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
use StdClass;
use Ngmy\StandCi\Library\StandCiCarbon;

class FileBuild implements BuildInterface {

	protected $directory;

	public function __construct($directory)
	{
		$this->directory = $directory;
	}

	/**
	 * Get single build by id.
	 *
	 * @param int $id Build ID
	 * @return StdClass Object of build information
	 */
	public function byId($id)
	{
		$file  = $this->directory.'/'.$id.'.json';
		$json  = File::get($file);
		$build = json_decode($json);
		$build->id = basename($file, '.json');

		$build = $this->convertTypeForObjcect($build);

		return $build;
	}

	/**
	 * Get paginated builds.
	 *
	 * @param int $page  Number of builds per page
	 * @param int $limit Results per page
	 * @return StdClass Object with $items and $totalItems for pagination
	 */
	public function byPage($page = 1, $limit = 10)
	{
		$result = new StdClass;
		$result->page       = $page;
		$result->limit      = $limit;
		$result->totalItems = 0;
		$result->items      = array();

		$totalBuilds = $this->all();
		$builds = array_slice($totalBuilds, $limit * ($page - 1), $limit);

		$result->totalItems = count($totalBuilds);
		$result->items      = $builds;

		return $result;
	}

	/**
	 * Get builds by the number of generations.
	 *
	 * @param int $generations Number of generations
	 * @return array Array of build objects
	 */
	public function byGeneration($generation)
	{
		$totalBuilds = $this->all();

		$builds = array_slice($totalBuilds, $generation);

		return $builds;
	}

	/**
	 * Get all builds.
	 *
	 * @return array Array of build objects
	 */
	public function all()
	{
		$files = File::files($this->directory);

		$builds = array();

		foreach ($files as $file) {
			$json = File::get($file);
			$data = json_decode($json);
			$data->id = basename($file, '.json');

			$data = $this->convertTypeForObjcect($data);

			$builds[] = $data;
		}

		// Sorting by started_at in descending order
		usort($builds, function ($a, $b)
		{
			if ($a->started_at === $b->started_at) {
				return 0;
			}

			return ($a->started_at < $b->started_at) ? 1 : -1;
		});

		return $builds;
	}

	/**
	 * Create a new Build.
	 *
	 * @param array $data Data to create a new Build
	 * @return boolean
	 */
	public function create(array $data)
	{
		$id   = $data['id'];
		$file = $this->directory.'/'.$id.'.json';

		unset($data['id']);

		$data = $this->convertTypeForFile($data);

		if (File::put($file, json_encode($data)) === false) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Update an existing Build.
	 *
	 * @param array $data Data to update a Build
	 * @return boolean
	 */
	public function update(array $data)
	{
		$id   = $data['id'];
		$file = $this->directory.'/'.$id.'.json';

		unset($data['id']);

		$data = $this->convertTypeForFile($data);

		$json = File::get($file);
		$oldData = json_decode($json, true);

		$newData = array_merge($oldData, $data);

		if (File::put($file, json_encode($newData)) === false) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Delete Build by id.
	 *
	 * @param int $id Build ID
	 * @return boolean
	 */
	public function deleteById($id)
	{
		$file = $this->directory.'/'.$id.'.json';

		return File::delete($file);
	}

	protected function convertTypeForObjcect(StdClass $data)
	{
		if (!is_null($data->started_at)) {
			$data->started_at = StandCiCarbon::createFromTimestamp($data->started_at);
		}

		if (!is_null($data->finished_at)) {
			$data->finished_at = StandCiCarbon::createFromTimestamp($data->finished_at);
		}

		if (!is_null($data->status)) {
			$data->status = (int) $data->status;
		}

		return $data;
	}

	protected function convertTypeForFile(array $data)
	{
		if (!is_null($data['started_at'])) {
			$data['started_at'] = $data['started_at']->format('U');
		}

		if (!is_null($data['finished_at'])) {
			$data['finished_at'] = $data['finished_at']->format('U');
		}

		if (!is_null($data['status'])) {
			$data['status'] = (string) $data['status'];
		}

		return $data;
	}

}
