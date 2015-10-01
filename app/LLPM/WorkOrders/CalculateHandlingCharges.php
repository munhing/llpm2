<?php

namespace LLPM\WorkOrders;

use LLPM\Repositories\FeeRepository;

class CalculateHandlingCharges		
{
	protected $feeRepository;
	protected $fees;

	public function __construct(FeeRepository $feeRepository)
	{
		
		$this->feeRepository = $feeRepository;
		// $this->fees = $this->getFees();
	}

	public function fire($workorder)
	{
		// dd($workorder->date);
		$charges = 0;

		// return 0 if there's no containers attached to the workorder
		if(count($workorder->containers) == 0) {
			return 0;
		}

		// get fees based on the workorder date
		$this->fees = $this->getFees($workorder->date);

		// dd($this->fees);
		foreach($workorder->containers as $container) {
			$charges += $this->getCharge($container);
		}

		return $charges;
	}

	public function getCharge($container)	
	{
		// get handling fees
		// $fees = $this->getFees();

		if($container->size == 20) {
			if($container->content == 'E') {
				return $this->fees['20E'];
			}

			if($container->content == 'L') {
				return $this->fees['20L'];
			}
		}

		if($container->size == 40) {
			if($container->content == 'E') {
				return $this->fees['40E'];
			}

			if($container->content == 'L') {
				return $this->fees['40L'];
			}
		}
	}

	public function getFees($carbonDate)
	{
		return json_decode($this->feeRepository->getHandlingFeeByDate($carbonDate), true); // arg true is to convert to array instead of object
	}
}