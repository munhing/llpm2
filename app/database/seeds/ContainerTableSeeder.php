<?php

use Carbon\Carbon;

class ContainerTableSeeder extends Seeder
{

	public function run()
	{
		$faker = Faker\Factory::create();

		$import_vessel_schedule_id = 284;
		$receiving_id = 0;

		for ($i=0;$i<150;$i++) {

			$eta = $faker->dateTimeThisYear()->format('Y-m-d');

			$etd = Carbon::createFromFormat('Y-m-d', $eta)->addDays($faker->randomDigit);

			Container::create([
				'container_no' => strtoupper($faker->bothify('????#######')),
				'size' => $faker->randomElement([20,40]),
				'content' => 'E',
				'status' => 1,
				'dl_check' => 0,
				'm_content' => 'E',
				'import_vessel_schedule_id' => $import_vessel_schedule_id
			]);
		}
	}
}