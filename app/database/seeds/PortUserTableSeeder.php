<?php

class PortUserTableSeeder extends Seeder
{

	public function run()
	{
		// $faker = Faker\Factory::create();

		// for ($i=0;$i<100;$i++) {
		// 	PortUser::create([
		// 		'name' => $faker->company
		// 	]);	
		// }

		$json = File::get(storage_path() . "/jsondata/portuser.json");
		$portusers = json_decode($json);

		//dd($vessels);
		foreach ($portusers as $portuser) {

			//dd($vessel->name);
			PortUser::create(array(
				'name' => $portuser->name
			));
		}		
	}
}