<?php namespace LLPM\Repositories;

use Country;

class CountryRepository {

	public function save(VesselSchedule $vesselSchedule)
	{
		return $vesselSchedule->save();
	}

	public function getAll()
	{
		return Country::all();
	}

	// public function getAllByMonth($month)
	// {
	// 	return VesselSchedule::with('vessel', 'portUser')
	// 			->selectRaw('vessel_schedule.*, vessels.name')
	// 			->join('vessels', 'vessel_schedule.vessel_id', '=', 'vessels.id')
	// 			->where('eta', 'like', $month . '%')
	// 			->orderBy('vessel_schedule.eta', 'desc')
	// 			->get();
	// }

	// public function getById($id)
	// {
	// 	return VesselSchedule::with('vessel', 'portUser')->find($id);
	// }

		// $reports = Report::with('client')->selectRaw("reports.*, clients.name, (`next_inspection`) > (NOW())  AS `status`")
		//        ->join('clients', 'reports.client_id', '=', 'clients.id')
		//        ->orderBy($sortby, $order)
		//        ->paginate(20);
}