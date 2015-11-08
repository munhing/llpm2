<?php

use Carbon\Carbon;

class ContainerTableSeeder extends Seeder
{

	public function run()
	{
		$faker = Faker\Factory::create();

		// fake data
		// $import_vessel_schedule_id = 284;
		// $receiving_id = 0;

		// for ($i=0;$i<150;$i++) {

		// 	$eta = $faker->dateTimeThisYear()->format('Y-m-d');

		// 	$etd = Carbon::createFromFormat('Y-m-d', $eta)->addDays($faker->randomDigit);

		// 	Container::create([
		// 		'container_no' => strtoupper($faker->bothify('????#######')),
		// 		'size' => $faker->randomElement([20,40]),
		// 		'content' => 'E',
		// 		'status' => 1,
		// 		'dl_check' => 0,
		// 		'm_content' => 'E',
		// 		'import_vessel_schedule_id' => $import_vessel_schedule_id
		// 	]);
		// }
		
		// real data
		
		// $results = DB::select('select * from containermovement where ctnmid > ? limit 15000', array(146143));
		// $results = DB::select('select * from containermovement where ctnmid > ? limit 15000', array(161315));
		$results = DB::select('select * from containermovement where ctnmid > ? limit 15000', array(176444));
		// 
		// $results = DB::select('select * from containermovement where ctnmid > ? limit 1000', array(176444));
		// 
		// $results = DB::select('select * from containermovement where ctnmid = ? limit 10000', array(177172));
		// $results = DB::select('select * from containermovement where ctnmid > ?', array(150000));
		// $results = DB::select('select * from containermovement where ctnmid = ?', array(152214));
		// $results = DB::select('select * from containermovement where ctnmid > ?', array(175528));

		// dd(count($results));

		foreach($results as $row) {
			var_dump($row->ctnmid . ' | ' . $row->ctnmctnno);

			$container = [];
			$container['id'] = $row->ctnmid;
			$container['container_no'] = $row->ctnmctnno;
			$container['size'] = $row->ctnmctnsize;
			$container['import_vessel_schedule_id'] = $row->ctnmvsidin;
			$container['export_vessel_schedule_id'] = $row->ctnmvsidout;

			$workorders = [];

			// dd($container);

			//validate container information
			$proceed = $this->validateContainerInfo($row);

			if(! $proceed) {
				var_dump('Skipped!');
				continue;
			}

			// get all workorders and content
			// firstly get the wonoin
			// 
			$proceed = $this->validateWorkOrderStatusPair($row);

			if($proceed) {
				$workorders = $this->getAllWorkOrders($row);
			}

			ksort($workorders);

			$proceed = $this->validateWorkOrders($workorders);

			if($proceed) {
				$this->migrateContainer($container, $workorders, $row);
			}

			// dd(json_encode($workorders));
			// dd($workorders);
		}
	}

	public function validateContainerInfo($row)
	{
		if($row->ctnmwonoin == 0) {
			if($row->ctnmvsidin == 0) {
				return false;
			}

			if(! ($row->ctnmstatusin == 'L' || $row->ctnmstatusin == 'E')) {
				return false;
			}			
		}

		if($row->ctnmwonoin != 0) {

			if(! ($row->ctnmstatusin == 'L' || $row->ctnmstatusin == 'E')) {
				return false;
			}

		}

		return true;	
	}

	public function getAllWorkOrders($row)
	{
		// get wonoin
		$workorders = [];
		$workorders = $this->extractWorkOrder($row->ctnmwonoin, $row->ctnmstatusin);

		// get other wo
		$workorders += $this->extractWorkOrder($row->ctnmwonoxtra, $row->ctnmstatusxtra);
		$workorders += $this->extractWorkOrder($row->ctnmwonot1, $row->ctnmstatust1);
		$workorders += $this->extractWorkOrder($row->ctnmwonot2, $row->ctnmstatust2);

		// get wonoout
		$workorders += $this->extractWorkOrder($row->ctnmwonoout, $row->ctnmstatusout);
		// dd($workorders);

		return $workorders;
	}	

	public function extractWorkOrder($workorder, $status)
	{
		$arr_wo = array_values(array_filter( explode(",", $workorder) ));
		$arr_status = array_values(array_filter( explode(",", $status) ));

		// var_dump($arr_wo);
		// var_dump($arr_status);
		
		$workorders = [];

		foreach($arr_wo as $key => $value) {
			$workorders[(int)$arr_wo[$key]]['workorder_no'] = $arr_wo[$key];
			$workorders[(int)$arr_wo[$key]]['content'] = $arr_status[$key];
		}
		// dd(count($arr_wo) . ' | ' . count($arr_status));
		// dd($arr_wo);


		// dd($workorders);

		return $workorders;
	}

	public function migrateContainer($container, $workorders, $row)
	{
		// dd($container);
		// dd($workorders);
		$container = $this->createContainer($container);

		if($row->ctnmwonoin != 0) {
			$this->attachContainerToWorkorder($container, $workorders);
		}
	}

	public function createContainer($container)
	{
		$con = Container::create([
			'id' => $container['id'],
			'container_no' => $container['container_no'],
			'size' => $container['size'],
			'status' => 2,
			'location' => 0,
			'export_vessel_schedule_id' => $container['export_vessel_schedule_id']
		]);

		if($container['import_vessel_schedule_id'] != 0) {
			$con->status = 1;
			$con->import_vessel_schedule_id = $container['import_vessel_schedule_id'];
			$con->save();
		}

		var_dump($con->id . ' | ' . $con->container_no . ' registered!');

		return $con;
	}

	public function attachContainerToWorkorder($container, $workorders)
	{
		// dd($workorders);
		$container_id = $container->id;

		foreach($workorders as $wo) {

			$container 	= Container::find($container_id);
			$workorder 	= WorkOrder::find($wo['workorder_no']);

			$status 	= $container->status;
			$location 	= $container->location;
			$movement 	= $workorder->movement;

			$type 		= $workorder->movement;

			if($type == 'HI') {
				$content = $wo['content'];
				$status = 3;
				$location = 1;
				$container->m_content = $wo['content'];			
			}

			if($type == 'HE') {
				$content = $wo['content'];
				$status = 4;
				$location = 0;
			}

			if($type == 'RI') {
				$content = $wo['content'];
				$status = 3;
				$location = 1;
				if($content == 'E') {
					$location = 3;
				}

				$movement = 'RI-' . $location;
			}

			if($type == 'RO') {
				$content 	= $wo['content'];
				$status 	= 4;
				$location	= 0;

				$movement = 'RO-' . $container->location;
			}

			if($type == 'T1') {
				$content 	= $wo['content'];
				$location	= 1;

				$movement = 'TF-3-1';
			}

			if($type == 'T2') {
				$content 	= $wo['content'];
				$location	= 3;

				$movement = 'TF-1-3';
			}

			if($type == 'EM') {
				$content 	= $this->changeContent($wo['content']);
				$location	= 1;

				$movement 	= $this->convertEM($wo['content']);
			}

			if($type == 'RI-1') {
				$content = $wo['content'];
				$status = 3;
				$location = 1;

				$movement = 'RI-1';
			}

			if($type == 'RI-3') {
				$content = $wo['content'];
				$status = 3;
				$location = 3;

				$movement = 'RI-3';
			}

			if($type == 'RO-1') {
				$content 	= $wo['content'];
				$status 	= 4;
				$location	= 0;

				$movement = 'RO-1';
			}

			if($type == 'RO-3') {
				$content 	= $wo['content'];
				$status 	= 4;
				$location	= 0;

				$movement = 'RO-3';
			}

			if($type == 'T1-3-1') {
				$content 	= $wo['content'];
				$location	= 1;

				$movement = 'TF-3-1';
			}

			if($type == 'T1-1-3') {
				$content 	= $wo['content'];
				$location	= 3;

				$movement = 'TF-1-3';
			}

			if($type == 'US') {
				$content 	= 'E';
				$location	= 1;

				$movement 	= 'US';
			}

			if($type == 'ST') {
				$content 	= 'L';
				$location	= 1;

				$movement 	= 'ST';
			}

			$container->content = $content;
			$container->status = $status;
			$container->location = $location;
			$container->save();

			$id = DB::table('container_workorder')->insertGetId([
				'container_id' => $container->id, 
				'workorder_id' => $workorder->id,
				'movement' => $movement,
				'content' => $wo['content'],
				'confirmed' => 1,
				'confirmed_by' => 1,
				'updated_at' => $workorder->date
			]);

			var_dump($id . ' | ' . $container->container_no . ' attached to ' . $workorder->id);
		}	
	}

	public function changeContent($content)
	{
		if($content == 'E') {
			return 'L';
		}

		return 'E';
	}

	public function convertEM($content)
	{
		if($content == 'E') {
			return 'ST';
		}

		return 'US';		
	}

	public function validateWorkOrders($workorders)
	{
		foreach($workorders as $wo) {
			if(count(WorkOrder::find($wo['workorder_no'])) == 0) {
				return false;
			}

		}

		return true;
		
	}

	public function validateWorkOrderStatusPair($row)
	{
		$result1 = $this->checkPair($row->ctnmwonoin, $row->ctnmstatusin);
		$result2 = $this->checkPair($row->ctnmwonoxtra, $row->ctnmstatusxtra);
		$result3 = $this->checkPair($row->ctnmwonot1, $row->ctnmstatust1);
		$result4 = $this->checkPair($row->ctnmwonot2, $row->ctnmstatust2);
		$result5 = $this->checkPair($row->ctnmwonoout, $row->ctnmstatusout);

		return ($result1 && $result2 && $result3 && $result4 && $result5);
	}

	public function checkPair($wono, $status)
	{
		$arr_wo = array_filter( explode(",", $wono) );
		$arr_status = array_filter( explode(",", $status) );

		if(count($arr_wo) != count($arr_status)) {		
			return false;
		}

		return true;
	}
}