<?php

class RoleTableSeeder extends Seeder
{

	public function run()
	{
		Role::create([
			'role' => 'AD',
			'description' => 'ADMINISTRATOR'
		]);

		Role::create([
			'role' => 'FO',
			'description' => 'FRONT OFFICE'
		]);

		Role::create([
			'role' => 'WF',
			'description' => 'WHARF OPERATOR'
		]);

		Role::create([
			'role' => 'MG',
			'description' => 'MAIN GATE'
		]);

		Role::create([
			'role' => 'PB',
			'description' => 'POLIS BANTUAN'
		]);

		Role::create([
			'role' => 'CY1',
			'description' => 'CY1 OPERATOR'
		]);			

		Role::create([
			'role' => 'CY3',
			'description' => 'CY3 OPERATOR'
		]);		

		Role::create([
			'role' => 'WH',
			'description' => 'WAREHOUSE OPERATOR'
		]);							
	}
}