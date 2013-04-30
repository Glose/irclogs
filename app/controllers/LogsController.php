<?php

class LogsController extends BaseController
{
	public function getIndex()
	{
		$logs = IrcLog::find();

		return View::make('logs')
			->with('logs', $logs);
	}
}