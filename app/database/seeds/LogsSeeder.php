<?php

class LogsSeeder extends Seeder {

	
	public function run()
	{
		exec('mongoimport -d irclogs -c logs --file app/database/seeds/logs.sample');
	}

}