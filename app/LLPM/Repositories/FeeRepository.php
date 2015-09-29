<?php

namespace LLPM\Repositories;

use Fee;

class FeeRepository {

	public function save(Fee $fee)
	{
		return $fee->save();
	}

	public function getHandlingFee()
	{
		return Fee::where('type','handling')->orderBy('effective_date', 'desc')->first()->fee;
	}

	public function getStorageFee()
	{
		return Fee::where('type','storage')->orderBy('effective_date', 'desc')->first()->fee;
	}

	public function getHandlingFees()
	{
		return Fee::where('type','handling')->orderBy('effective_date', 'desc')->get();
	}

	public function getStorageFees()
	{
		return Fee::where('type','storage')->orderBy('effective_date', 'desc')->get();
	}	
}