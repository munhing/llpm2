<?php namespace LLPM\Repositories;

use Cargo;
use Container;

class CargoRepository {

	public function save(Cargo $cargo)
	{
		$cargo->save();
		return $cargo;
	}

	public function getAll()
	{
		return Cargo::all();
	}

	public function getAllWithStatus2And3()
	{
		return Cargo::whereIn('status', [2,3])
				->orderBy('bl_no')
				->get();
	}

	public function getImportLooseCargoWithStatus1And3()
	{
		return Cargo::where('containerized', 0)
				->whereIn('status', [1,3])
				->where('import_vessel_schedule_id', '!=', 0)
				->orderBy('bl_no')
				->get();
	}

	public function getExportLooseCargoWithStatus1And3()
	{
		return Cargo::where('containerized', 0)
				->whereIn('status', [1,3])
				->where('export_vessel_schedule_id', '!=' , 0)
				->orderBy('bl_no')
				->get();
	}

	public function containerizedIncrement($cargo_id, $int)
	{
		$cargo = cargo::find($cargo_id);
		$cargo->increment('containerized', $int);
	}

	public function containerizedDecrement($cargo_id, $int)
	{
		$cargo = cargo::find($cargo_id);
		$cargo->decrement('containerized', $int);
	}

	public function getByBlNo($blNo)
	{
		return Cargo::where('bl_no', $blNo)
			->first();
	}

	public function getById($id)
	{
		return Cargo::with('containers', 'm_containers')->find($id);
	}
	
	public function getImportById($id)
	{
		return Cargo::with('importSchedule', 'consignor', 'consignee', 'containers','m_containers')
			->find($id);
	}

	public function getExportById($id)
	{
		return Cargo::with('consignor', 'consignee', 'containers', 'exportSchedule')
			->find($id);
	}

	public function getAllByScheduleId($vesselScheduleId)
	{
		return Cargo::with('consignor', 'consignee', 'importContainers')
			->where('vessel_schedule_id', $vesselScheduleId)
			->orderBy('bl_no')
			->get();		
	}

	public function attachToVesselSchedule($importCargo, $vessel_schedule_id)
	{
		return $importCargo->schedule()->attach($vessel_schedule_id);
	}

	public function attachToContainer(Cargo $cargo, Container $container)
	{
		// check whether both id's already listed in the pivot table
		if (!$cargo->containers->contains($container->id)) {
	    	$cargo->containers()->attach($container);
		}
	}

	public function m_attachToContainer(Cargo $cargo, Container $container)
	{
		// check whether both id's already listed in the pivot table
		if (!$cargo->m_containers->contains($container->id)) {
	    	$cargo->m_containers()->attach($container);
		}
	}

	public function detachFromContainer(Cargo $cargo, Container $container)
	{
	    $cargo->containers()->detach($container);
	}

	public function m_detachFromContainer(Cargo $cargo, Container $container)
	{
	    $cargo->m_containers()->detach($container);
	}

	public function getAllForSelectList()
	{
		return Cargo::selectRaw("id, bl_no AS text")->orderBy('text')->get();
	}

	public function getActiveExportCargoForSelectList()
	{
		return Cargo::selectRaw("id, bl_no AS text")
			->where('export_vessel_schedule_id', '!=', 0)
			->where('status', 3)
			->orderBy('text')
			->get();
	}	
}