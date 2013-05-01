<?php

class LogsController extends BaseController
{

	/**
	 * Display the latest logs
	 */
	public function index()
	{
		$logs = IrcLog::find();

		return View::make('logs')
			->with('logs', $logs);
	}

	/**
	 * Search in the database and display results
	 */
	public function search()
	{
		$q    = Input::get('q');
		$logs = IrcLog::textSearch($q);

		if (Request::ajax()) {
			return View::make('partials.logs', compact('logs'));
		}

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
