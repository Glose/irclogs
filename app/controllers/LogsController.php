<?php
use Carbon\Carbon;

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
		if (!$datetime) {
			$datetime = Carbon::now()->subMinutes(5);
		}
		
		list($firstLog, $logs, $moreup, $moredown) = IrcLog\Repository::getAroundDate($datetime);

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
		list($filter, $sort, $more) = ($direction == 'up') ?
			array('$lt', -1, 'reset') :
			array('$gt',  1, 'end');
		
		// Fetch the logs
		$logs = IrcLog::find(array(
				'time' => array($filter => $log->time),
			))
			->sort(array('time' => $sort))
			->limit($this->ajaxLoad)
			->all();
		
		$loadMore = null;
		if (count($logs) == $this->ajaxLoad) {
			$loadMore = $more($logs)->_id;
		}
		
		return View::make('partials.logs')
			->with('logs', $logs)
			->with('more' . $direction, $loadMore);
	}
}
