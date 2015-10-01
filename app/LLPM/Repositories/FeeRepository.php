<?php

namespace LLPM\Repositories;

use Fee;

class FeeRepository {

	public function save(Fee $fee)
	{
		return $fee->save();
	}

	// Get latest Handling fees
	public function getHandlingFee()
	{
		return Fee::where('type','handling')->orderBy('effective_date', 'desc')->first()->fee;
	}

	// Get latest Storage fees
	public function getStorageFee()
	{
		return Fee::where('type','storage')->orderBy('effective_date', 'desc')->first()->fee;
	}

	// Get all handling fees
	public function getHandlingFees()
	{
		return Fee::where('type','handling')->orderBy('effective_date', 'desc')->get();
	}

	// Get all storage fees
	public function getStorageFees()
	{
		return Fee::where('type','storage')->orderBy('effective_date', 'desc')->get();
	}	

	// Get correct Handling fees according to the workorder date
	// the Date must be a Carbon object
	public function getHandlingFeeByDate($carbonDate)
	{
		$fees = $this->getHandlingFees();

		foreach($fees as $fee) {

			if($carbonDate >= $fee->effective_date) {
				// {"20E":, "20L":, "40E":, "40L":}
				return $fee->fee;
			}
		}		
	}

	// Get correct Storage fees according to the workorder date
	// the Date must be a Carbon object
	public function getStorageFeeByDate($carbonDate)
	{
		$fees = $this->getStorageFees();

		foreach($fees as $fee) {

			if($carbonDate >= $fee->effective_date) {
				// {"20E":, "20L":, "40E":, "40L":}
				return $fee->fee;
			}
		}		
	}		
}