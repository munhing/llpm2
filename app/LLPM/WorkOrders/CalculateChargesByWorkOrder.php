<?php

namespace LLPM\WorkOrders;

use Illuminate\Support\Facades\Log;
use LLPM\WorkOrders\CalculateHandlingCharges;
use LLPM\WorkOrders\CalculateStorageCharges;

class CalculateChargesByWorkOrder		
{
	protected $calculateHandlingCharges;

	public function __construct(
		CalculateHandlingCharges $calculateHandlingCharges,
		CalculateStorageCharges $calculateStorageCharges
	)
	{
		$this->calculateHandlingCharges = $calculateHandlingCharges;
		$this->calculateStorageCharges = $calculateStorageCharges;
	}

	public function fire($workorder)
	{
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
}