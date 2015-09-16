<?php

use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{

	public function run()
	{
		$faker = Faker::create();

		$user = User::register(
			'ad',
			'Thomas',
			'ad@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(1);

		$user = User::register(
			'fo', 
			'Jeff', 
			'fo@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(2);

		$user = User::register(
			'wf', 
			'David', 
			'wf@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(3);

		$user = User::register(
			'mg', 
			'Kevin', 
			'mg@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(4);

		$user = User::register(
			'pb', 
			'Adnan', 
			'pb@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(5);

		$user = User::register(
			'cy1', 
			'Bryan', 
			'cy1@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(6);

		$user = User::register(
			'cy3', 
			'Chris', 
			'cy3@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(7);

		for($i=0; $i<30; $i++) {

			$username = $faker->bothify('??#');

			$user = User::register(
				$username,
				$faker->name,
				$username . '@llpm.com.my',
				'1234'
			);

			$user->save();
			$user->roles()->attach($faker->randomElement([1, 2, 3, 4, 5, 6, 7]));
		}






	}
}