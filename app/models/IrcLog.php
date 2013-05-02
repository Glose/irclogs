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
			'message'  => Html::entities($this->text),
		));
	}

	/**
	 * Returns a DateTime object from the hour
	 */
	public function getCarbon()
	{
		return Carbon::createFromTimeStamp($this->time->sec);
	}

	/**
	 * Returns the hour of the entry
	 *
	 * @return  string
	 */
	public function getHour()
	{
		return $this->getCarbon()->format('H:i');
	}
	
	/**
	 * Returns the day of the entry
	 *
	 * @return string
	 */
	public function getDay()
	{
		return $this->getCarbon()->format('l, d M');
	}
	
	/**
	 * Returns an URL for the entry
	 * 
	 * @return string
	 */
	public function getUrl()
	{
		return $this->getCarbon()->format('Y-m-d/H:i').'#log-'.$this->id;
	}
	
}
