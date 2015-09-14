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
		$this->fees = $this->getFees();
	}

	public function fire($workorder)
	{
		$charges = 0;

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

	public function getFees()
	{
		// {"20E":, "20L":, "40E":, "40L":}
		return json_decode($this->feeRepository->getHandlingFee(), true); // arg true is to convert to array instead of object
	}
}