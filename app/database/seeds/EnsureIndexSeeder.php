<?php

class EnsureIndexes extends Seeder
{
  public function run()
  {
    Log::ensureIndex(array(
      'text' => 'text'
    ));
  }
}
