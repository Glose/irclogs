<?php

class LogsController extends BaseController
{
	public function index()
	{
		$logs = IrcLog::find();

		return View::make('logs')
			->with('logs', $logs);
	}
	
	
	public function search()
	{
		$q = Input::get('q');
		
		$search = Mongovel::db()->command(array('text' => 'logs', 'search' => $q));
		
		var_dump($search);
	}
}