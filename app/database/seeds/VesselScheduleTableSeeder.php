<?php

use Carbon\Carbon;

class VesselScheduleTableSeeder extends Seeder
{

	public function run()
	{
		$faker = Faker\Factory::create();

		for ($i=0;$i<500;$i++) {

			$eta = $faker->dateTimeThisYear()->format('Y-m-d');

			$etd = Carbon::createFromFormat('Y-m-d', $eta)->addDays($faker->randomDigit);

			VesselSchedule::create([
				'vessel_id' => Vessel::orderBy(DB::raw('RAND()'))->first()->id,
				'portuser_id' => PortUser::orderBy(DB::raw('RAND()'))->first()->id,
				'voyage_no_arrival' => $faker->bothify('##/###'),
				'voyage_no_departure' => $faker->bothify('##/###'),
				'eta' => $eta,
				'etd' => $etd,
				'mt_arrival' => $faker->randomFloat(2, 1, 2500),
				'mt_departure' => $faker->randomFloat(2, 1, 2500),
				'm3_arrival' => $faker->randomFloat(2, 1, 2500),
				'm3_departure' => $faker->randomFloat(2, 1, 2500)
			]);
		}
	}
}