<?php 

namespace LLPM\Repositories;

use VesselSchedule;
use Carbon\Carbon;

class VesselScheduleRepository {

	public function save(VesselSchedule $vesselSchedule)
	{
		return $vesselSchedule->save();
	}

	public function getAll()
	{
		return VesselSchedule::with('vessel')
				->selectRaw('vessel_schedule.*, vessels.name')
				->join('vessels', 'vessel_schedule.vessel_id', '=', 'vessels.id')
				->orderBy('vessel_schedule.eta')
				->get();
	}

	public function getAllByMonth($month)
	{
		return VesselSchedule::with('vessel', 'portUser')
				->selectRaw('vessel_schedule.*, vessels.name')
				->join('vessels', 'vessel_schedule.vessel_id', '=', 'vessels.id')
				->where('eta', 'like', $month . '%')
				->orderBy('vessel_schedule.eta', 'desc')
				->get();
	}

	public function getActiveSchedule()
	{
		return VesselSchedule::selectRaw('vessel_schedule.*, vessels.name')
				->join('vessels', 'vessel_schedule.vessel_id', '=', 'vessels.id')
				->whereRaw("(`etd`) >= NOW()")
				->orderBy('vessels.name')
				->get();
	}

	public function getById($id)
	{
		return VesselSchedule::with('vessel', 'portUser')->find($id);
	}

	public function getDetailsById($id)
	{
		return VesselSchedule::with(['vessel', 'portUser', 
				'importCargoes' => function($query){
					$query->with('m_containers');
				}, 
				'importContainers'
			])->find($id);
	}

		// $reports = Report::with('client')->selectRaw("reports.*, clients.name, (`next_inspection`) > (NOW())  AS `status`")
		//        ->join('clients', 'reports.client_id', '=', 'clients.id')
		//        ->orderBy($sortby, $order)
		//        ->paginate(20);
}