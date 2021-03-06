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

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Routing\Controller as BaseController;
use Ngmy\StandCi\Repo\Build\BuildInterface;
use Ngmy\StandCi\Service\Lock\LockerInterface;

class BuildsController extends BaseController
{
	protected $build;

	protected $locker;

	public function __construct(BuildInterface $build, LockerInterface $locker)
	{
		$this->build = $build;

		$this->locker = $locker;
	}

	/**
	 * List builds.
	 *
	 * @return void
	 */
	public function index()
	{
		$page    = Input::get('page', 1);
		$perPage = 10;

		$isLock   = $this->locker->isLock();
		$pagiData = $this->build->byPage($page, $perPage);

		$builds = new Paginator($pagiData->items, $pagiData->totalItems, $perPage);
		$builds->setPath('/'.config('ngmy-stand-ci')['route_prefix'].'/builds');

		if (Request::header('X-PJAX')) {
			return View::make('stand-ci::builds.index_pjax', array('builds' => $builds, 'isLock' => $isLock));
		} else {
			return View::make('stand-ci::builds.index', array('builds' => $builds, 'isLock' => $isLock));
		}
	}

	/**
	 * Create build form processing.
	 *
	 * @return void
	 */
	public function store()
	{
		system('php ../artisan stand-ci:build > /dev/null &');
		system('php ../artisan stand-ci:housekeep --max-builds='.config('ngmy-stand-ci')['max_builds'].' > /dev/null &');
	}

	/**
	 * Show single build.
	 *
	 * @param int $id Build ID
	 * @return void
	 */
	public function show($id)
	{
		$tab = Input::get('tab');

		$build = $this->build->byId($id);

		switch ($tab) {
		case 'phpunit':
			return View::make('stand-ci::builds.show_phpunit', array('build' => $build));
		case 'coverage':
			return View::make('stand-ci::builds.show_coverage', array('build' => $build));
		case 'phpdoc':
			return View::make('stand-ci::builds.show_phpdoc', array('build' => $build));
		case 'phpcb':
			return View::make('stand-ci::builds.show_phpcb', array('build' => $build));
		case 'phpcs':
			return View::make('stand-ci::builds.show_phpcs', array('build' => $build));
		case 'phpcpd':
			return View::make('stand-ci::builds.show_phpcpd', array('build' => $build));
		case 'phpmd':
			return View::make('stand-ci::builds.show_phpmd', array('build' => $build));
		case 'metrics':
			return View::make('stand-ci::builds.show_metrics', array('build' => $build));
		default:
			return View::make('stand-ci::builds.show_overview', array('build' => $build));
		}
	}

}
