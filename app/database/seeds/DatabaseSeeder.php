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
			'vessels'
			// 'port_users'
			// 'vessel_schedule'
			// 'settings',
            // 'cargoes',
            // 'import_dl'
            // 'export_dl'
            
            // 'workorders'
            // 'container_workorder',
            // 'containers'
            // 'container_confirmation_process'
   //          'fees',
   //          'containers',
   //          'cargo_container',
   //          'cargo_items',
   //          'container_workorder',
            // 'container_workorder_confirmation'
   //          'm_cargo_container',
   //          'receiving',
   //          'workorders'
			// 'users'
			// 'permission_role'
		];
   //          'permissions'
   //          'custom_tariff',
			// 'roles',
			// 'role_user',

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		foreach ($tables as $table) {
			DB::table($table)->truncate();
		}
		
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		// $this->call('PortUserTableSeeder');
		$this->call('VesselTableSeeder');
		// $this->call('VesselScheduleTableSeeder');
        // $this->call('CargoTableSeeder');	// Set the value for $import_vessel_schedule_id
        // $this->call('CargoExportTableSeeder');	// Set the value for $import_vessel_schedule_id
        // $this->call('WorkOrderTableSeeder');	// Set the value for $import_vessel_schedule_id
        // $this->call('WorkOrderTransformMovement2TableSeeder');	// Set the value for $import_vessel_schedule_id
        // $this->call('ContainerConfirmationTableSeeder');	// Set the value for $import_vessel_schedule_id
        // $this->call('ContainerTableSeeder'); // Set the value for $import_vessel_schedule_id
		// $this->call('RoleTableSeeder');
		// $this->call('UserTableSeeder');		
		// $this->call('SettingsTableSeeder');
		// $this->call('ContainerConfirmationProcessTableSeeder');
		// $this->call('FeesTableSeeder');
  //       $this->call('UpdateAutoIncrement');

		// // Do this after the above finish and then determine which vessel id
  //       $this->call('AttachContainerToCargoSeeder'); // Set the value for $import_vessel_schedule_id
  //       $this->call('UpdateSchedule'); // Set the value for $import_vessel_schedule_id
  //       $this->call('TariffTableSeeder');
  //       $this->call('PermissionsTableSeeder');
	}

}
