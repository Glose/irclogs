<?php

class LogsController extends BaseController
{
	public static $FORMAT = 'Y-m-d';
	
	/**
	 * Display the latest logs
	 */
	public function index($date = null)
	{
		$filter = array();
		if ($date = DateTime::createFromFormat(static::$FORMAT, $date)) {
			$filter = array(
				'time' => array('$gt' => new MongoDate($date->getTimestamp())),
			);
		}
		$logs = IrcLog::find($filter)->limit(200);

		return View::make('logs')
			->with('logs', $logs);
	}

	/**
	 * Search in the database and display results
	 */
	public function search()
	{
		$q      = Input::get('q');
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
