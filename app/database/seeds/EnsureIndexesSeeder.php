<?php

class EnsureIndexesSeeder extends Seeder
{
	public function run()
	{
		IrcLog::ensureIndex(array('text' => 'text'));
		IrcLog::ensureIndex(array('time' => 1));
	}
}
