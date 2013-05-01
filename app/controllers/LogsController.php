<?php

class LogsController extends BaseController
{
	public static $DATE_FORMAT = 'Y-m-d';
	public static $TIME_FORMAT = 'Y-m-d/H:i';
	public static $AJAX_LOAD   = 200;
	
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
	
	/**
	 * Ajax infinite loading
	 */
	public function infinite($id, $direction)
	{
		$log = IrcLog::findOneOrFail($id);
		list($filter, $sort, $more) = $direction == 'up' ? array('$lt', -1, 'reset') : array('$gt', 1, 'end');
		$logs = IrcLog::find(array(
				'time' => array($filter => $log->time),
			))
			->sort(array('time' => $sort))
			->limit(static::$AJAX_LOAD)
			->all();
		$loadMore = null;
		if (count($logs) == static::$AJAX_LOAD) {
			$loadMore = $more($logs);
		}
		
		return View::make('logs')
			->with('logs', $logs)
			->with($direction, $loadMore);
	}
}
