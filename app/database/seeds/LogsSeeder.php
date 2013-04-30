<?php

class LogsSeeder extends Seeder {

	
	public function run()
	{
		exec('mongoimport -d irclogs -c logs2 --file app/database/seeds/logs.sample');
	}

}