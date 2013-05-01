<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/{date?}/{time?}', 'LogsController@index')
	->where('date', '[0-9]{4}-[0-1][0-9]-[0-3][0-9]')
	->where('time', '[0-2][0-9]:[0-5][0-9]');

Route::get('search/',         'LogsController@search');
Route::get('search/{query?}', 'LogsController@search');

/*
|--------------------------------------------------------------------------
| View composers
|--------------------------------------------------------------------------
|*/

View::composer('partials.timeline', function($view) {

	$timeline = array();
	
	// Fetch start and end time
	$firstLog  = IrcLog::find()->sort(array('time' => 1))->limit(1)[0];
	$lastLog   = IrcLog::find()->sort(array('time' => -1))->limit(1)[0];
	$firstDate = $firstLog->getDateTime()->format('Y-m-d');
	$lastDate  = $lastLog->getDateTime()->format('Y-m-d');

	// Loop and add to timeline
	while (strtotime($firstDate) <= strtotime($lastDate)) {
		list($year, $month, $day) = explode('-', $firstDate);
		$timeline[$year][$month][$day] = URL::to($year.'-'.$month.'-'.$day. '/00:00');

		$firstDate = date ("Y-m-d", strtotime("+1 day", strtotime($firstDate)));
	}

	$view->timeline = $timeline;

});
