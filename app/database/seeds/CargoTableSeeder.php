<?php

use Carbon\Carbon;

class CargoTableSeeder extends Seeder
{

	public function run()
	{
		$faker = Faker\Factory::create();

		$import_vessel_schedule_id = 27;
		$receiving_id = 0;

		for ($i=0;$i<100;$i++) {

			$eta = $faker->dateTimeThisYear()->format('Y-m-d');

			$etd = Carbon::createFromFormat('Y-m-d', $eta)->addDays($faker->randomDigit);

			Cargo::create([
				'bl_no' => $faker->bothify('SLLBU##########'),
				'consignor_id' => PortUser::orderBy(DB::raw('RAND()'))->first()->id,
				'consignee_id' => PortUser::orderBy(DB::raw('RAND()'))->first()->id,
				'mt' => $faker->randomFloat(2, 1, 2500),
				'm3' => $faker->randomFloat(2, 1, 2500),
				'status' => 1,
				'description' => $faker->paragraph(),
				'markings' => $faker->paragraph(),
				'import_vessel_schedule_id' => $import_vessel_schedule_id,
				'receiving_id' => $receiving_id = 0
			]);
		}
	}
}