<?php

class ChangeWorkorderNo extends Seeder
{

	public function run()
	{

		// dd('Hello');
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		$w1 = 119804;
		$w2 = 119803;
		$temp = 111;

		// change the workorder id that you want to a temporary small number
		
		// change the container_workorder first
		$tempNo = WorkOrder::find($w2);

		foreach($tempNo->containers as $container) {
			var_dump($container->pivot->workorder_id);
			$container->pivot->workorder_id = $temp;
			$container->pivot->save();
		}

		$tempNo->id = $temp;
		$tempNo->save();

		// ****************************************
		
		$workorder1 = WorkOrder::find($w1);

		foreach($workorder1->containers as $container) {
			var_dump($container->pivot->workorder_id);
			$container->pivot->workorder_id = $w2;
			$container->pivot->save();
		}

		$workorder1->id = $w2;
		$workorder1->save();

		// ****************************************
		
		$workorder2 = WorkOrder::find($temp);

		foreach($workorder2->containers as $container) {
			var_dump($container->pivot->workorder_id);
			$container->pivot->workorder_id = $w1;
			$container->pivot->save();
		}

		$workorder2->id = $w1;
		$workorder2->save();


		// foreach ($tables as $table) {
		// 	DB::table($table)->truncate();
		// }
		
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');		

	}
}