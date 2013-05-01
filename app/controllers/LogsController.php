<?php

class LogsController extends BaseController
{
	public static $DATE_FORMAT = 'Y-m-d';
	public static $TIME_FORMAT = 'Y-m-d/H:i';
	
	/**
	 * Display the latest logs
	 */
	public function index($date = null)
	{
		$datetime = null;
		if ($date) {
			$datetime = DateTime::createFromFormat(static::$TIME_FORMAT, $date);
		}
		if ($date && !$datetime) {
			$datetime = DateTime::createFromFormat(static::$DATE_FORMAT, $date);
		}
		if (!$datetime) {
			$datetime = new DateTime('@'.(time() - 5*60));
		}
		
		list($firstLog, $logs) = IrcLog\Repository::getAroundDate($datetime);
		return View::make('logs')
			->with('logs', $logs)
			->with('firstLog', $firstLog);
	}

	/**
	 * Search in the database and display results
	 */
	public function search($q = null)
	{
		$logs   = IrcLog::textSearch($q);
		$search = true;

		if (Request::ajax()) {
			return View::make('partials.logs', compact('logs', 'search'));
		}

		return View::make('logs')
			->with('logs', $logs)
			->with('search', $search);
	}
	
}
