<?php

use Carbon\Carbon;

class FeesTableSeeder extends Seeder
{

	public function run()
	{

		Fee::create([
			'type' => 'handling',
			'fee' => '{"20E":100, "20L":225, "40E":150, "40L":350}',
			'effective_date' => Carbon::createFromDate(2015, 1, 1)
		]);

        Fee::create([
            'type' => 'storage',
            'fee' => '{"20":6, "40":12}',
            'effective_date' => Carbon::createFromDate(2015, 1, 1)
        ]);        
	}
}