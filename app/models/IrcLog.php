<?php
use Mongovel\Model;

class IrcLog extends Model
{
	protected $collectionName = 'logs';

	/**
	 * Get the log's message
	 *
	 * @return  string
	 */
	public function getText()
	{
		return Lang::get('messages.'.$this->type, array(
			'username' => $this->nick,
			'message'  => $this->text,
		));
	}

	/**
	 * Returns a DateTime object from the hour
	 */
	public function getDateTime()
	{
		return new DateTime('@'.$this->time->sec);
	}

	/**
	 * Returns the hour of the entry
	 *
	 * @return  string
	 */
	public function getHour()
	{
		return $this->getDateTime()->format('H:i');
	}
	
	/**
	 * Returns the day of the entry
	 *
	 * @return string
	 */
	public function getDay()
	{
		return $this->getDateTime()->format('D, d M');
	}
	
	/**
	 * Returns an URL for the entry
	 * 
	 * @return string
	 */
	public function getUrl()
	{
		return date('Y-m-d/H:i', $this->time->sec);
	}
}
