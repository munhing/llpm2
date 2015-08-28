<?php

class UserTableSeeder extends Seeder
{

	public function run()
	{
		$user = User::register(
			'ad', 
			'ad@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(1);

		$user = User::register(
			'fo', 
			'fo@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(2);

		$user = User::register(
			'wf', 
			'wf@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(3);

		$user = User::register(
			'mg', 
			'mg@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(4);

		$user = User::register(
			'pb', 
			'pb@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(5);

		$user = User::register(
			'cy1', 
			'cy1@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(6);

		$user = User::register(
			'cy3', 
			'cy3@llpm.com.my', 
			'1234'
		);

		$user->save();
		$user->roles()->attach(7);					
	}
}