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
			'operator_id'=>$operator,
			'role'=> $container->to_confirm_by,
			'confirmed_at'=> $confirmed_at
		]);

	}

	public function getAllByWorkorders($workorder_list)
	{
		return ContainerWorkorderConfirmation::with(['container', 'user', 'containerConfirmation'])->whereIn('workorder_id', $workorder_list)->orderBy('confirmed_at')->get();
	}

	public function getAllByDateAndLocations($date, $locations = null)
	{
		if($locations == null) {
			return ContainerWorkorderConfirmation::with(['container', 'containerConfirmation'])
					->where('confirmed_at', 'like', $date->format('Y-m-d') . '%')
					->orderBy('confirmed_at')
					->get();
		}

		return ContainerWorkorderConfirmation::with(['container', 'containerConfirmation'])
				->where('confirmed_at', 'like', $date->format('Y-m-d') . '%')
				->whereIn('role', $locations)
				->orderBy('confirmed_at')
				->get();		
	}

	public function getAll()
	{
		return ContainerWorkorderConfirmation::with('user', 'operator', 'container', 'workorder', 'containerConfirmation')->orderBy('confirmed_at', 'desc')->get();
	}
}