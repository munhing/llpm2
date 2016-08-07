<?php

use Carbon\Carbon;
use LLPM\Repositories\ContainerConfirmationRepository;
use LLPM\Repositories\ContainerWorkorderConfirmationRepository;
use LLPM\Repositories\VesselScheduleRepository;
use LLPM\Repositories\WorkOrderRepository;

class ReportsController extends \BaseController {

	protected $workOrderRepository;
	protected $containerWorkorderConfirmationRepository;
	protected $containerConfirmationRepository;
	protected $vesselScheduleRepository;


	function __construct(
		WorkOrderRepository $workOrderRepository,
		ContainerWorkorderConfirmationRepository $containerWorkorderConfirmationRepository,
		ContainerConfirmationRepository $containerConfirmationRepository,
		VesselScheduleRepository $vesselScheduleRepository
	)
	{
		parent::__construct();
		$this->workOrderRepository = $workOrderRepository;
		$this->containerWorkorderConfirmationRepository = $containerWorkorderConfirmationRepository;
		$this->containerConfirmationRepository = $containerConfirmationRepository;
		$this->vesselScheduleRepository = $vesselScheduleRepository;
	}
	/**
	 * Display a listing of the resource.
	 * GET /reports
	 *
	 * @return Response
	 */
	public function index()
	{
		// dd('Various Reports');
		return View::make('reports/index')->withAccess($this->access);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /reports/create
	 *
	 * @return Response
	 */
	public function containerLoadingDischargingConf()
	{
		return View::make('reports/container_loading_discharging_conf')->withAccess($this->access);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /reports
	 *
	 * @return Response
	 */
	public function containerLoadingDischargingRpt()
	{
		$schedule_id = Input::get('schedule_id');
		$movement = Input::get('movement');
		$rpt = [];

		$workorders = $this->workOrderRepository->getAllByScheduleId($schedule_id, $movement);
		$schedule = $this->vesselScheduleRepository->getById($schedule_id);

		// dd($schedule);
		$cc = $this->containerWorkorderConfirmationRepository->getAllByWorkorders($workorders->lists('id'));


		$info['carrier'] = $schedule->vessel->name;
		$info['voyage'] = 'V.' . $schedule->voyage_no_arrival . ' / V.' . $schedule->voyage_no_departure;
		$info['period'] = $schedule->eta->format('Y-m-d') . ' / ' . $schedule->etd->format('Y-m-d');

		$i=0;
		foreach($cc as $c) {
			if( $c->role == 'CY1') {
				continue;
			}
			// var_dump($c->container->container_no . ' | ' . $c->role . ' | ' . $c->confirmed_at);
			// var_dumP($c->toArray());
			$rpt[$i]['confirmed_at'] = $c->confirmed_at; 
			$rpt[$i]['container_no'] = $c->container->container_no; 
			$rpt[$i]['size'] = $c->container->size . $c->containerConfirmation->content;
			$rpt[$i]['workorder'] = $c->workorder_id;
			$rpt[$i]['movement'] = $c->containerConfirmation->movement;
			$rpt[$i]['role'] = $c->role; 
			$rpt[$i]['activity'] = $this->getActivity($c->role, $c->containerConfirmation->movement);;

			$i++;
		}


		return View::make('reports/container_loading_discharging_rpt', compact('info', 'rpt'))->withAccess($this->access);
	}

	/**
	 * Display the specified resource.
	 * GET /reports/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function containerMovementConf()
	{
		return View::make('reports/container_movement_conf')->withAccess($this->access);
	}

	public function containerMovementRpt()
	{
		$date = Carbon::createFromFormat('Y-m-d H', Input::get('date') . " 0");
		$locations = json_decode(Input::get('locations'), true);
		$rpt = [];

		// dd($locations);
		$info['date'] = $date;
		$info['locations'] = $this->getLocations($locations);

		// dd($info['locations']);

		$cc = $this->containerWorkorderConfirmationRepository->getAllByDateAndLocations($date, $locations);

		$i = 0;

		foreach($cc as $c) {
			// var_dump($c->confirmed_at . ' | ' . $c->container->container_no . ' | ' . $c->container->size . $c->containerConfirmation->content . ' | ' . $c->role . ' | ' . $c->workorder_id . ' | ' . $c->containerConfirmation->movement);

			$rpt[$i]['confirmed_at'] = $c->confirmed_at;
			$rpt[$i]['container_no'] = $c->container->container_no;
			$rpt[$i]['size'] = $c->container->size . $c->containerConfirmation->content;
			$rpt[$i]['location'] = $c->role;
			$rpt[$i]['workorder'] = $c->workorder_id;
			$rpt[$i]['movement'] = $c->containerConfirmation->movement;
			$rpt[$i]['activity'] = $this->getActivity($c->role, $c->containerConfirmation->movement);

			$i++;
		}
		// dd($rpt);

		return View::make('reports/container_movement_rpt', compact('info', 'rpt'))->withAccess($this->access);
	}

	public function getLocations($locations)
	{
		if($locations == null) {
			return 'All';
		}

		$location = '';
		$i = 1;
		foreach($locations as $loc) {
			if($i == count($locations)) {
				$location .= $loc;
			} else {
				$location .= $loc . ' | ';
			}

			$i++;
		}

		return $location;
	}

	public function getActivity($location, $movement)
	{
		$activity['WF']['HI'] = 'Discharging';
		$activity['WF']['HE'] = 'Loading';

		$activity['CY1']['HI'] = 'Lifting Off';
		$activity['CY1']['HE'] = 'Lifting On';
		$activity['CY1']['ST'] = 'Stuffing';
		$activity['CY1']['US'] = 'Unstuffing';
		$activity['CY1']['RI-1'] = 'Lifting Off';
		$activity['CY1']['RO-1'] = 'Lifting On';
		$activity['CY1']['TF-1-3'] = 'Lifting On';
		$activity['CY1']['TF-3-1'] = 'Lifting Off';

		$activity['CY3']['RI-3'] = 'Lifting Off';
		$activity['CY3']['RO-3'] = 'Lifting On';
		$activity['CY3']['TF-1-3'] = 'Lifting Off';
		$activity['CY3']['TF-3-1'] = 'Lifting On';		
	
		$activity['MG']['RI-1'] = 'Drive In';
		$activity['MG']['RO-1'] = 'Drive Out';
		$activity['MG']['TF-1-3'] = 'Drive Out';
		$activity['MG']['TF-3-1'] = 'Drive In';

		$activity['PB']['RI-3'] = 'Drive In';
		$activity['PB']['RO-3'] = 'Drive Out';
		$activity['PB']['TF-1-3'] = 'Drive In';
		$activity['PB']['TF-3-1'] = 'Drive Out';

		return $activity[$location][$movement];
	}
	/**
	 * Show the form for editing the specified resource.
	 * GET /reports/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /reports/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /reports/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}