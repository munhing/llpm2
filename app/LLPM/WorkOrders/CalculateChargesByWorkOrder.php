<?php

namespace LLPM\WorkOrders;

use Illuminate\Support\Facades\Log;
use LLPM\Repositories\WorkOrderRepository;
use LLPM\WorkOrders\CalculateHandlingCharges;
use LLPM\WorkOrders\CalculateStorageCharges;
use WorkOrder;

class CalculateChargesByWorkOrder		
{
	protected $calculateHandlingCharges;
	protected $workOrderRepository;

	public function __construct(
		CalculateHandlingCharges $calculateHandlingCharges,
		CalculateStorageCharges $calculateStorageCharges,
		WorkOrderRepository $workOrderRepository
	)
	{
		$this->calculateHandlingCharges = $calculateHandlingCharges;
		$this->calculateStorageCharges = $calculateStorageCharges;
		$this->workOrderRepository = $workOrderRepository;
	}

	public function fire($workorder)
	{
		// dd($workorder);
		$workorder = $this->checkInstance($workorder);
		
		$handlingCharges = $this->calculateHandlingCharges->fire($workorder);
		$storageCharges = $this->calculateStorageCharges->fire($workorder);

		// Update workorder
		$this->updateWorkorder($workorder, $handlingCharges, $storageCharges);

		Log::info('Storage Charges: ' . $storageCharges);
		Log::info('Handling Charges: ' . $handlingCharges);

	}

	public function updateWorkorder($workorder, $handlingCharges, $storageCharges)
	{
		$workorder->handling_charges = $handlingCharges;
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