<?php
namespace IrcLog;

use DateTime;
use IrcLog;
use MongoDate;


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
		$UP_LIMIT   = 100;
		$DOWN_LIMIT = 200;
		
		$logs = IrcLog::find(array(
				'time' => array('$gt' => new MongoDate($date->getTimestamp())),
			))
			->sort(array('time' => 1))
			->limit($DOWN_LIMIT)
			->all();
		
		$previousLogs = array_reverse(
			IrcLog::find(array(
				'time' => array('$lte' => new MongoDate($date->getTimestamp())),
			))
			->sort(array('time' => -1))
			->limit($UP_LIMIT)
			->all()
		);
		return array(end($previousLogs), array_merge($previousLogs, $logs));
	}

}
