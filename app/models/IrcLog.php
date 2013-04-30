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
	 * Returns the hour of the entry
	 *
	 * @return  string
	 */
	public function getHour()
	{
		return date('H:i', $this->time->sec);
	}
}