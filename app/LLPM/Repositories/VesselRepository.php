<?php namespace LLPM\Repositories;

use Vessel;

class VesselRepository {

	public function save(Vessel $vessel)
	{
		return $vessel->save();
	}

	public function getAll()
	{
		return Vessel::orderBy('name')->get();
	}

}