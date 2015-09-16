<?php namespace LLPM\Repositories;

use Auth;
use ContainerWorkorderConfirmation;
use ContainerConfirmation;

class ContainerWorkorderConfirmationRepository {

	public function confirmationEntry($container, $operator, $confirmed_at)
	{
		$containerConfirmationId = ContainerConfirmation::where('container_id', $container->id)
			->where('workorder_id', $container->workorders->last()->id)
			->first()
			->id;

		ContainerWorkorderConfirmation::create([
			'container_id'=>$container->id,
			'container_no'=>$container->container_no,
			'workorder_id'=>$container->workorders->last()->id,
			'container_workorder_id'=>$containerConfirmationId,
			'confirmed_by'=> Auth::user()->id,
			'operator'=>$operator,
			'role'=> $container->to_confirm_by,
			'confirmed_at'=> $confirmed_at
		]);

	}

	public function getAll()
	{
		return ContainerWorkorderConfirmation::with('container', 'workorder', 'containerConfirmation')->get();
	}
}