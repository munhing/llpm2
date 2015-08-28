<?php namespace LLPM\Repositories;

use ContainerWorkorderConfirmation;
use Auth;

class ContainerWorkorderConfirmationRepository {

	public function confirmationEntry($container)
	{
		// $info = [
		// 	'container_id'=>$container->id,
		// 	'container_no'=>$container->container_no,
		// 	'workorder_id'=>$container->workorders->last()->id,
		// 	'workorder_no'=>$container->workorders->last()->workorder_no,
		// 	'confirmed_by'=> Auth::user()->id,
		// 	'role'=> Auth::user()->roles->first()->role,
		// 	'confirmed_at'=> date('Y-m-d H:i:s')
		// ];

		// dd($container->toArray());
		// dd($info);

		ContainerWorkorderConfirmation::create([
			'container_id'=>$container->id,
			'container_no'=>$container->container_no,
			'workorder_id'=>$container->workorders->last()->id,
			'workorder_no'=>$container->workorders->last()->workorder_no,
			'confirmed_by'=> Auth::user()->id,
			'role'=> Auth::user()->roles->first()->role,
			'confirmed_at'=> date('Y-m-d H:i:s')
		]);

	}
}