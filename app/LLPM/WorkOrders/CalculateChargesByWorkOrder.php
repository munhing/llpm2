<?php

namespace LLPM\WorkOrders;

use Illuminate\Support\Facades\Log;
use LLPM\WorkOrders\CalculateHandlingCharges;

class CalculateChargesByWorkOrder		
{
	protected $calculateHandlingCharges;

	public function __construct(CalculateHandlingCharges $calculateHandlingCharges)
	{
		$this->calculateHandlingCharges = $calculateHandlingCharges;
	}

	public function fire($workorder)
	{
		$handlingCharges = $this->calculateHandlingCharges->fire($workorder);

		Log::info('Handling Charge: ' . $handlingCharges);
		// $storageCharges = $this->calculateStorageCharges($workorder);

		// Update workorder
		$this->updateWorkorder($workorder, $handlingCharges);
	}

	public function updateWorkorder($workorder, $handlingCharges)
	{
		$workorder->handling_charges = $handlingCharges;
		// $workorder->storage_charges = $storageCharges;

		$workorder->save();
	}
}