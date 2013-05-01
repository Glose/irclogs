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
		$q      = Input::get('q');
		$logs   = IrcLog::textSearch($q);
		$search = true;

		if (Request::ajax()) {
			return View::make('partials.logs', compact('logs', 'search'));
		}

		return View::make('logs')
			->with('logs', $logs)
			->with('search', $search);
	}

}
