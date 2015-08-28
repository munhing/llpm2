<?php namespace LLPM\Repositories;

use WorkOrder;

class WorkOrderRepository {

	public function save(WorkOrder $workOrder)
	{
		return $workOrder->save();
	}

	public function getDetailsById($id)
	{
		return WorkOrder::with('handler', 'carrier', 'vesselSchedule', 'containers')
				->find($id);
	}

	public function getAllByMonth($month)
	{
		return WorkOrder::with('handler', 'carrier', 'vesselSchedule')
				->where('date', 'like', $month . '%')
				->orderBy('workorders.date', 'desc')
				->get();
	}

	public function getById($id)
	{
		return WorkOrder::find($id);
	}

	public function getByWorkOrderNo($workorder_no)
	{
		return WorkOrder::where('workorder_no', $workorder_no)->first();
	}

	public function cancelContainer($workorder_id, $container_id)
	{
		$workorder = $this->getById($workorder_id);
		$workorder->containers()->detach($container_id);

		return true;
	}	
}