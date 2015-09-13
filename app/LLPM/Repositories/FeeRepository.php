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
		return Fee::where('type','handling')->first()->fee;
	}

}