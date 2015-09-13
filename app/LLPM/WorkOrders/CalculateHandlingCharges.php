<?php

namespace LLPM\WorkOrders;

use LLPM\Repositories\FeeRepository;

class CalculateHandlingCharges		
{
	protected $feeRepository;

	public function __construct(FeeRepository $feeRepository)
	{
		
		$this->feeRepository = $feeRepository;
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
		$fees = $this->getFees();

		if($container->size == 20) {
			if($container->content == 'E') {
				return $fees['20E'];
			}

			if($container->content == 'L') {
				return $fees['20L'];
			}
		}

		if($container->size == 40) {
			if($container->content == 'E') {
				return $fees['40E'];
			}

			if($container->content == 'L') {
				return $fees['40L'];
			}
		}
	}

	public function getFees()
	{
		return json_decode($this->feeRepository->getHandlingFee(), true);
	}
}