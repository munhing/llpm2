<?php

use Carbon\Carbon;

class WorkOrderTableSeeder extends Seeder
{

	public function run()
	{
		$faker = Faker\Factory::create();

		$errors = [];

		// real data 2015 July onwards
		$results = DB::select('select * from workorder where woid > ?', array(104623));

		// dd(count($results));

		foreach($results as $row) {

			if($row->wocarrier != 0) {
				$wocarrier = DB::select("select * from handler where hid = ?", array($row->wocarrier));
				if(count($wocarrier) != 0) {
					$carrier = PortUser::where('name', $wocarrier[0]->hname)->first();
					$carrier_id = $carrier->id;
				} else {
					$carrier_id = 1;
				}
			}

			$wohandler = DB::select("select * from handler where hid = ?", array($row->wohid));
			if(count($wohandler) != 0) {
				$handler = PortUser::where('name', $wohandler[0]->hname)->first();
				$handler_id = $handler->id;
			} else {
				$handler_id = 1;
			}
			// dd($agent[0]->aid);
			$proceed = true;

			if($row->wom == 'HI' || $row->wom == 'HE') {
				$schedule = VesselSchedule::find($row->wovsid);
				if(count($schedule) == 0){
					$proceed = false;
				}
			}

			if($proceed){
				try{

					// var_dump('Registering '. $row->wono);

					WorkOrder::create(array(
						'id'		=> $row->wono,
						'movement'	=> $row->wom,
						'date'		=> $row->wodate,
						'carrier_id'	=> $carrier_id,
						'handler_id'	=> $handler_id,
						'vessel_schedule_id'	=> $row->wovsid,
						'storage_charges'		=> $row->emptycharges,
						'handling_charges'		=> $row->hdlcharges
					));
				} catch(Exception $e) {
					var_dump($row->wono);
				}
			}
		}

		// var_dump($errors);

	}
}