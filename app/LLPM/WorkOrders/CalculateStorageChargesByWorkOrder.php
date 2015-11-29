<?php

namespace LLPM\WorkOrders;

use Illuminate\Support\Facades\Log;
use LLPM\Repositories\WorkOrderRepository;
use LLPM\WorkOrders\CalculateStorageCharges;
use WorkOrder;

class CalculateStorageChargesByWorkOrder		
{
	protected $calculateStorageCharges;
	protected $workOrderRepository;

	public function __construct(
		CalculateStorageCharges $calculateStorageCharges,
		WorkOrderRepository $workOrderRepository
	)
	{
		$this->calculateStorageCharges = $calculateStorageCharges;
		$this->workOrderRepository = $workOrderRepository;
	}

	public function fire($workorder)
	{
		// dd($workorder);
		$workorder = $this->checkInstance($workorder);
		
		$storageCharges = $this->calculateStorageCharges->fire($workorder);

		// dd($storageCharges);

		// Update workorder
		$this->updateWorkorder($workorder, $storageCharges);

		// Log::info('Storage Charges: ' . $storageCharges);
		Log::info('Storage Charges: ' . $storageCharges);

	}

	public function updateWorkorder($workorder, $storageCharges)
	{
		$workorder->storage_charges = $storageCharges;

		$workorder->save();
	}

	public function checkInstance($workorder)
	{
		if($workorder instanceOf WorkOrder) {
			return $workorder;
		}

		return $this->workOrderRepository->getById($workorder);
	}
}