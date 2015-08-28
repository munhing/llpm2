<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$tables = [
			'vessels',
			'port_users',
			'vessel_schedule',
			'roles',
			'settings',
			'users'
		];

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		foreach ($tables as $table) {
			DB::table($table)->truncate();
		}
		
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		$this->call('PortUserTableSeeder');
		$this->call('VesselTableSeeder');
		$this->call('VesselScheduleTableSeeder');
		$this->call('RoleTableSeeder');
		$this->call('UserTableSeeder');		
		$this->call('SettingsTableSeeder');
		$this->call('ContainerConfirmationProcessTableSeeder');
	}

}
