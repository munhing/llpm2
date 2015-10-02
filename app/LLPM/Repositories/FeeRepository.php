<?php

namespace LLPM\Repositories;

use Fee;
use Carbon\Carbon;

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
		// dd($carbonDate);
		$carbonDate = $this->checkCarbon($carbonDate);

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
		$carbonDate = $this->checkCarbon($carbonDate);

		$fees = $this->getStorageFees();

		foreach($fees as $fee) {

			if($carbonDate >= $fee->effective_date) {
				// {"20E":, "20L":, "40E":, "40L":}
				return $fee->fee;
			}
		}		
	}		

	public function checkCarbon($date)
	{
		if($date instanceof Carbon) {
			return $date;
		}

		return Carbon::parse($date);
	}
}