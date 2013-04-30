<?php

class EnsureIndexesSeeder extends Seeder
{
	public function run()
	{
		IrcLog::ensureIndex(array(
			'text' => 'text',
			'time' => 1,
		));
	}
}
