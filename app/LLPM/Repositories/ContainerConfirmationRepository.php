<?php namespace LLPM\Repositories;

use ContainerConfirmation;

class ContainerConfirmationRepository {

	public function save(ContainerConfirmation $containerConfirmation)
	{
		return $containerConfirmation->save();
	}

	public function getById($id)
	{
		return ContainerConfirmation::with('container', 'workorder')->find($id);
	}

	public function getByWorkOrderId($id)
	{
		return ContainerConfirmation::with(['container', 'user'])->where('workorder_id', '=', $id)->get();
	}

	public function getAll()
	{
		// return ContainerConfirmation::with('container', 'workorder')
		// 								->get();

		return ContainerConfirmation::with('container', 'workorder')
				->selectRaw('container_workorder.*, containers.container_no, workorders.workorder_no')
		       	->join('containers', 'container_workorder.container_id', '=', 'containers.id')
		       	->join('workorders', 'container_workorder.workorder_id', '=', 'workorders.id')
		       	->where('confirm', 0)
		       	->orderBy('containers.container_no')
		       	->get();										
	}

	public function getPendingByContainerId($container_id)
	{
		return ContainerConfirmation::where('container_id', $container_id)
										->where('confirm', 0)
										->first();
	}

}