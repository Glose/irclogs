<?php

class LogsController extends BaseController
{
	/** 
	 * The format of dates
	 *
	 * @var string
	 */
	protected $dateFormat = 'Y-m-d';
	
	/** 
	 * The format of datetime
	 *
	 * @var string
	 */
	protected $datetimeFormat = 'Y-m-d/H:i';
	
	/** 
	 * The number of logs to load via AJAX
	 *
	 * @var integer
	 */
	protected $ajaxLoad = 200;

	////////////////////////////////////////////////////////////////////
	///////////////////////////// LOG FETCHING /////////////////////////
	////////////////////////////////////////////////////////////////////
	
	/**
	 * Display the latest logs
	 */
	public function index($date = null)
	{
		$datetime = null;
		if ($date) {
			$datetime = DateTime::createFromFormat($this->datetimeFormat, $date);
		}
		if ($date && !$datetime) {
			$datetime = DateTime::createFromFormat($this->dateFormat, $date);
		}
		if ($datetime) {
			list($firstLog, $logs, $moreup, $moredown) = IrcLog\Repository::getAroundDate($datetime);
		}
		else {
			list($firstLog, $logs, $moreup) = IrcLog\Repository::getLatest();
			$moredown = null;
		}
		
		return View::make('logs')
			->with('logs', $logs)
			->with('firstLog', $firstLog)
			->with('moreup', $moreup)
			->with('moredown', $moredown);
	}

	/**
	 * Search in the database and display results
	 */
	public function search($q = null)
	{
		$logs   = IrcLog::textSearch($q);
		$search = true;

		if (Request::ajax()) {
			if (!$logs->count()) {
				return '<p>No results were found</p>';
			}

			return View::make('partials.logs', compact('logs', 'search'));
		}

		return View::make('logs')
			->with('logs', $logs)
			->with('search', $search);
	}
	
	/**
	 * Ajax infinite loading
	 */
	public function infinite($direction, $id)
	{
		$log = IrcLog::findOneOrFail($id);
		
		// Build the query to fetch logs with
		list($filter, $sort) = ($direction == 'up') ?
			array('$lt', -1) :
			array('$gt',  1);
		
		// Fetch the logs
		$logs = IrcLog::find(array(
				'time' => array($filter => $log->time),
			))
			->sort(array('time' => $sort))
			->limit($this->ajaxLoad)
			->all();
		
		$loadMore = null;
		if (count($logs) == $this->ajaxLoad) {
			$loadMore = end($logs)->_id;
		}
		if ($direction == 'up') {
			$logs = array_reverse($logs);
		}
		return View::make('partials.logs')
			->with('logs', $logs)
			->with('more' . $direction, $loadMore);
	}
}
