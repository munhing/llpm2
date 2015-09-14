<?php

namespace LLPM\WorkOrders;

use LLPM\Repositories\FeeRepository;

class CalculateStorageCharges		
{
	protected $feeRepository;
	protected $fees;
	protected $days_free = 5;

	public function __construct(FeeRepository $feeRepository)
	{
		
		$this->feeRepository = $feeRepository;
		$this->fees = $this->getFees();
	}

	public function fire($workorder)
	{
		$charges = 0;

		$movement = explode('-', $workorder->movement);

		if($movement[0] != 'HE' || $movement[0] != 'RO') {
			return 0;
		}

		// return 0 if there's no containers attached to the workorder
		if(count($workorder->contaienrs) == 0) {
			return 0;
		}

		foreach($workorder->containers as $container) {
			$charges += $this->getCharge($container);
		}

		return $charges;
	}

	public function getCharge($container)	
	{
		// storage fee is only applicable to empty storage
		// formula: [total_empty_days - 5_days] * [storage_fee]
		$days_empty = $container->days_empty;
		$container_size = $container->size;

		$days_chargeable = $days_empty - $this->days_free;

		if($days_chargeable <= 0) {
			return 0;
		}

		return $days_chargeable * $this->fees[$container_size];
	}

	public function getFees()
	{
		return json_decode($this->feeRepository->getStorageFee(), true); // arg true is to convert to array instead of object
	}
}