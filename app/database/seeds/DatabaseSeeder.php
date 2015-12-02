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
			// 'vessels'
			// 'port_users'
			// 'vessel_schedule'
			// 'roles'
			// 'users'
            // 'permissions'
            // 'fees'
            // 'custom_tariff'
            // 'workorders'
            // 'container_confirmation_process'
            // 'containers',
            // 'container_workorder'

            // 'cargoes',
            // 'import_dl',
            // 'export_dl'
            
			// 'settings',
   //          'containers',
   //          'cargo_container',
   //          'cargo_items',
   //          'container_workorder',
            // 'container_workorder_confirmation'
   //          'm_cargo_container',
   //          'receiving',
			// 'permission_role'
		];
			// 'role_user',

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		foreach ($tables as $table) {
			DB::table($table)->truncate();
		}
		
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		// $this->call('VesselTableSeeder');
		// $this->call('PortUserTableSeeder');
		// $this->call('VesselScheduleTableSeeder');
		// $this->call('RoleTableSeeder');
		// $this->call('UserTableSeeder');		
        // $this->call('PermissionsTableSeeder');
		// $this->call('FeesTableSeeder');
        // $this->call('TariffTableSeeder');
        // $this->call('WorkOrderTableSeeder');	// Set the value for $import_vessel_schedule_id
		// $this->call('ContainerConfirmationProcessTableSeeder');
        // $this->call('ContainerTableSeeder'); // Set the value for $import_vessel_schedule_id
        // $this->call('WorkOrderTransformMovementTableSeeder');	// Update workorder movement to latest code and update who_is_involved
        // $this->call('CargoTableSeeder');
        // $this->call('CargoExportTableSeeder');
        

        $this->call('ChangeWorkorderNo');
        
        // $this->call('ContainerConfirmationTableSeeder');	// Set the value for $import_vessel_schedule_id

	}

}
