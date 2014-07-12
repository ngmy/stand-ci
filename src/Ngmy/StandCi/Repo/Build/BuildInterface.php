<?php namespace Ngmy\StandCi\Repo\Build;
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

interface BuildInterface {

	const SUCCESS = 0;

	const FAILURE = 1;

	const IN_PROCESS = 2;

	/**
	 * Get single build by id.
	 *
	 * @param int $id Build ID
	 * @return StdClass Object of build information
	 */
	public function byId($id);

	/**
	 * Get paginated builds.
	 *
	 * @param int $page  Number of builds per page
	 * @param int $limit Results per page
	 * @return StdClass Object with $items and $totalItems for pagination
	 */
	public function byPage($page = 1, $limit = 10);

	/**
	 * Get builds by the number of generations.
	 *
	 * @param int $generations Number of generations
	 * @return array Array of build objects
	 */
	public function byGeneration($generation);

	/**
	 * Get all builds.
	 *
	 * @return array Array of build objects
	 */
	public function all();

	/**
	 * Create a new Build.
	 *
	 * @param array $data Data to create a new Build
	 * @return boolean
	 */
	public function create(array $data);

	/**
	 * Update an existing Build.
	 *
	 * @param array $data Data to update a Build
	 * @return boolean
	 */
	public function update(array $data);

	/**
	 * Delete Build by id.
	 *
	 * @param int $id Build ID
	 * @return boolean
	 */
	public function deleteById($id);

}
