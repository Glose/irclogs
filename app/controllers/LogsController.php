<?php

class LogsController extends BaseController
{
	public static $DATE_FORMAT = 'Y-m-d';
	public static $TIME_FORMAT = 'Y-m-d H:i';
	
	/**
	 * Display the latest logs
	 */
	public function index($date = null, $time = null)
	{
		$datetime = null;
		if ($time && $date) {
			$datetime = DateTime::createFromFormat(static::$TIME_FORMAT, $date.' '.$time);
		}
		if ($date && !$datetime) {
			$datetime = DateTime::createFromFormat(static::$DATE_FORMAT, $date);
		}
		
		$filter = array();
		if ($datetime) {
			$filter = array(
				'time' => array('$gt' => new MongoDate($datetime->getTimestamp())),
			);
		}
		
		$logs = IrcLog::find($filter)->sort(array('time' => 1))->limit(200);

		return View::make('logs')
			->with('logs', $logs);
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
