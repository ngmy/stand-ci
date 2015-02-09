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

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App;
use Ngmy\StandCi\Exception\StandCiException;

class StandCiExceptionHandler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param \Exception $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		if ($e instanceOf StandCiException) {
			$standCiException = App::make('stand-ci.exception');
			$standCiException->handle($e);
			return;
		}

		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Exception $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		return parent::render($request, $e);
	}

}
