<?php
namespace IrcLog;

use DateTime;
use IrcLog;
use MongoDate;
use URL;

class Repository
{
	/**
	 * Get logs around $date
	 *
	 * @param DateTime  $date
	 *
	 * @return array
	 */
	public static function getAroundDate(DateTime $date)
	{
		$upLimit   = 100;
		$downLimit = 200;
		$mongoDate = new MongoDate($date->getTimestamp());
		
		$logs = IrcLog::find(array(
				'time' => array('$gt' => $mongoDate),
			))
			->sort(array('time' => 1))
			->limit($downLimit)
			->all();
		
		$previousLogs = array_reverse(
			IrcLog::find(array(
				'time' => array('$lte' => $mongoDate),
			))
			->sort(array('time' => -1))
			->limit($upLimit)
			->all()
		);

		return array(
			end($previousLogs),
			array_merge($previousLogs, $logs),
			count($previousLogs) == $upLimit ? reset($previousLogs)->_id : null,
			count($logs) == $downLimit ? end($logs)->_id : null,
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
		$firstLog  = IrcLog::find()->sort(array('time' => 1))->limit(1)[0];
		$lastLog   = IrcLog::find()->sort(array('time' => -1))->limit(1)[0];
		$firstDate = $firstLog->getDateTime()->format('Y-m-d');
		$lastDate  = $lastLog->getDateTime()->format('Y-m-d');

		// Loop and add to timeline
		while (strtotime($firstDate) <= strtotime($lastDate)) {
			list($year, $month, $day) = explode('-', $firstDate);
			$timeline[$year][$month][$day] = URL::to($year.'-'.$month.'-'.$day);

			$firstDate = date ("Y-m-d", strtotime("+1 day", strtotime($firstDate)));
		}

		return $timeline;
	}

}
