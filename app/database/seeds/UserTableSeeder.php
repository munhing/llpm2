<?php

use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{

	public function run()
	{
		$faker = Faker::create();

		$user = User::register(
			'Thomas',
			'ad',
			'ad@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(1);

		$user = User::register(
			'Jeff', 
			'fo', 
			'fo@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(2);

		$user = User::register(
			'David', 
			'wf', 
			'wf@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(3);

		$user = User::register(
			'Kevin', 
			'mg', 
			'mg@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(4);

		$user = User::register(
			'Adnan', 
			'pb', 
			'pb@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(5);

		$user = User::register(
			'Bryan', 
			'cy1', 
			'cy1@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(6);

		$user = User::register(
			'Chris', 
			'cy3', 
			'cy3@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(7);


		for($i=0; $i<30; $i++) {

			$username = $faker->bothify('??#');

			$user = User::register(
				$faker->name,
				$username,
				$username . '@llpm.com.my',
				'1234'
			);

			$user->save();
			$user->roles()->attach($faker->randomElement([1, 2, 3, 4, 5, 6, 7]));
		}

		$user = User::create([
			'id' => 100,
			'username' => 'migration', 
			'name' => 'Migration', 
			'email' => 'migration@llpm.com.my', 
			'password' => '1234'
		]);
		$user->roles()->attach([1, 2, 3, 4, 5, 6, 7]);





	}
}