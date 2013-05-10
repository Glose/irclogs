<?php
namespace IrcLog;

use DateTime;
use IrcLog;
use MongoDate;
use Carbon;
use URL;

class Repository
{
	/**
	 * Number of logs to load above the requested date
	 *
	 * @var int
	 */
	protected static $upLimit = 100;
	
	/**
	 * Number of logs to load after the requested date
	 *
	 * @var int
	 */
	protected static $downLimit = 200;
	
	/**
	 * Get latest logs
	 *
	 * @return array
	 */
	public static function getLatest()
	{
		$logs = array_reverse(IrcLog::find()
			->sort(array('time' => -1))
			->limit(static::$downLimit + static::$upLimit)
			->all());
		return array(
			end($logs),
			$logs,
			count($logs) == static::$upLimit + static::$downLimit ? reset($logs)->_id : null
		);
	}

	/**
	 * Get logs around $date
	 *
	 * @param DateTime  $date
	 *
	 * @return array
	 */
	public static function getAroundDate(DateTime $date)
	{
		$mongoDate = new MongoDate($date->getTimestamp());
		
		$logs = IrcLog::find(array(
				'time' => array('$gt' => $mongoDate),
			))
			->sort(array('time' => 1))
			->limit(static::$downLimit)
			->all();
		
		$previousLogs = array_reverse(
			IrcLog::find(array(
				'time' => array('$lte' => $mongoDate),
			))
			->sort(array('time' => -1))
			->limit(static::$upLimit)
			->all()
		);

		return array(
			end($previousLogs),
			array_merge($previousLogs, $logs),
			count($previousLogs) == static::$upLimit ? reset($previousLogs)->_id : null,
			count($logs) == static::$downLimit ? end($logs)->_id : null,
		);
	}

	/**
	 * Get a timeline from the first to the last log entry
	 *
	 * @return array
	 */
	public static function getTimeline()
	{
		$timeline = array();

		// Fetch start and end time
		$firstLog  = IrcLog::find()->sort(array('time' => 1))->limit(1)->first();
		$lastLog   = IrcLog::find()->sort(array('time' => -1))->limit(1)->first();
		$firstDate = $firstLog->getCarbon()->format('Y-m-d');
		$lastDate  = $lastLog->getCarbon()->format('Y-m-d');

		// Loop and add to timeline
		while (strtotime($firstDate) <= strtotime($lastDate)) {
			list($year, $month, $day) = explode('-', $firstDate);
			$timeline[$year][$month][$day] = Carbon::createFromDate($year, $month, $day);

			$firstDate = date ("Y-m-d", strtotime("+1 day", strtotime($firstDate)));
		}

		return $timeline;
	}

}
