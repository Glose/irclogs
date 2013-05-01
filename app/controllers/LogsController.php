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
		
		$logs = IrcLog::textSearch($q);
		
		return View::make('logs')
			->with('logs', $logs)
			->with('search', true);
	}
	
	
	//////////////////////////////////////////////////////////////////////
	//////////////////////////////// API /////////////////////////////////
	//////////////////////////////////////////////////////////////////////

	public function apiSearch()
	{
		$q = Input::get('q');
		
		$logs = IrcLog::textSearch($q);
		
		return Response::json($logs);
	}
}
