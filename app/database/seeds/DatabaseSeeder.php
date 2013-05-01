<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		
		IrcLog::drop();
		$this->call('EnsureIndexesSeeder');
		$this->call('LogsSeeder');
	}

}
