<?php

use Carbon\Carbon;
use LLPM\Repositories\ContainerConfirmationRepository;
use LLPM\Repositories\ContainerWorkorderConfirmationRepository;
use LLPM\Repositories\VesselScheduleRepository;
use LLPM\Repositories\WorkOrderRepository;
use LLPM\Reports\ReportsManager;
use Illuminate\Support\Collection;

class ReportsController extends \BaseController {

	protected $workOrderRepository;
	protected $containerWorkorderConfirmationRepository;
	protected $containerConfirmationRepository;
	protected $vesselScheduleRepository;
	protected $reportsManager;


	function __construct(
		WorkOrderRepository $workOrderRepository,
		ContainerWorkorderConfirmationRepository $containerWorkorderConfirmationRepository,
		ContainerConfirmationRepository $containerConfirmationRepository,
		VesselScheduleRepository $vesselScheduleRepository,
		ReportsManager $reportsManager
	)
	{
		parent::__construct();
		$this->workOrderRepository = $workOrderRepository;
		$this->containerWorkorderConfirmationRepository = $containerWorkorderConfirmationRepository;
		$this->containerConfirmationRepository = $containerConfirmationRepository;
		$this->vesselScheduleRepository = $vesselScheduleRepository;
		$this->reportsManager = $reportsManager;
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

	public function totalTEUsConf()
	{
		return View::make('reports/total_teus_conf')->withAccess($this->access);
	}

	public function totalTEUsRpt()
	{
		$year = $this->reportsManager->getYear(Input::get('year'));
		// dd($year);
		// get all import export containers
		$teus = $this->reportsManager->getAllImportExport($year);
		

		$monthly = $this->reportsManager->getTeusMonthBySize($teus, 20);
		$total_teus = $this->reportsManager->getTotalTeus($teus);
		$teus_count_20 = $this->reportsManager->getTeusCountBySize($teus, 20);		
		$teus_count_40 = $this->reportsManager->getTeusCountBySize($teus, 40);

		// dd($monthly, $teus_count_20, $teus_count_40);

		return View::make('reports/total_teus_rpt', 
			compact(
				'year',
				'monthly',
				'total_teus',
				'teus_month_40',
				'teus_count_20',
				'teus_count_40'
		))->withAccess($this->access);
	}

	public function cargoMtConf()
	{
		return View::make('reports/cargo_mt_conf')->withAccess($this->access);
	}

	public function cargoMtRpt()
	{
		$year = $this->reportsManager->getYear(Input::get('year'));
		// get all import export containers
		$importCargo = $this->reportsManager->getCargoImportByYear($year);
		$exportCargo = $this->reportsManager->getCargoexportByYear($year);

		$monthly = $this->reportsManager->getMonthly($importCargo, 'monthly');
		$import = $this->reportsManager->convertDecimalValuesToArray($importCargo, 'total_mt');
		$export = $this->reportsManager->convertDecimalValuesToArray($exportCargo, 'total_mt');

		return View::make('reports/cargo_mt_rpt', 
			compact(
				'year',
				'monthly',
				'import',
				'export'
		))->withAccess($this->access);
	}

	public function cargoTopImportConf()
	{
		return View::make('reports/cargo_top_import_conf')->withAccess($this->access);
	}

	public function cargoTopImportRpt()
	{
		$year = $this->reportsManager->getYear(Input::get('year'));
		$cargoes = $this->reportsManager->getTopImportCargoItemByYear($year);

		// dd($cargoes->toArray());
		return View::make('reports/cargo_top_import_rpt', 
			compact(
				'year',
				'cargoes'
		))->withAccess($this->access);		

	}

	public function cargoTopExportConf()
	{
		return View::make('reports/cargo_top_export_conf')->withAccess($this->access);
	}

	public function cargoTopExportRpt()
	{
		$year = $this->reportsManager->getYear(Input::get('year'));
		$cargoes = $this->reportsManager->getTopExportCargoItemByYear($year);

		// dd($cargoes->toArray());
		return View::make('reports/cargo_top_export_rpt', 
			compact(
				'year',
				'cargoes'
		))->withAccess($this->access);		
	}

	public function cargoListImportConf()
	{
		return View::make('reports/cargo_list_import_conf')->withAccess($this->access);
	}

	public function cargoListImportRpt()
	{
		$year = $this->reportsManager->getYear(Input::get('year'));
		$consignee_id = Input::get('consignee_id');

		// dd($consignee_id, $year);
		$cargoes = $this->reportsManager->getImportCargoListByConsigneeAndYear($consignee_id, $year);
		$consignee = $cargoes->first()->name;
		// dd($cargoes->toArray());
		// dd($consignee);

		return View::make('reports/cargo_list_import_rpt', 
			compact(
				'year',
				'cargoes',
				'consignee'
		))->withAccess($this->access);	
	}

	public function cargoListExportConf()
	{
		return View::make('reports/cargo_list_export_conf')->withAccess($this->access);
	}

	public function cargoListExportRpt()
	{
		$year = $this->reportsManager->getYear(Input::get('year'));
		$consignor_id = Input::get('consignor_id');

		// dd($consignor_id, $year);
		$cargoes = $this->reportsManager->getExportCargoListByConsignorAndYear($consignor_id, $year);
		if(count($cargoes)) {
			$consignor = $cargoes->first()->name;
		} else {
			$consignor = '';
		}
		// dd($cargoes->toArray());
		// dd($consignee);

		return View::make('reports/cargo_list_export_rpt', 
			compact(
				'year',
				'cargoes',
				'consignor'
		))->withAccess($this->access);	
	}

	public function totalVesselConf()
	{
		return View::make('reports/total_vessel_conf')->withAccess($this->access);
	}

	public function totalVesselRpt()
	{
		$year = $this->reportsManager->getYear(Input::get('year'));
		$vessel = $this->reportsManager->getVesselCountByYear($year);

		$monthly = $this->reportsManager->getMonthly($vessel, 'v_month');
		$values = $this->reportsManager->convertValuesToArray($vessel, 'v_count');

		return View::make('reports/total_vessel_rpt', 
			compact(
				'year','monthly','values'
		))->withAccess($this->access);	
	}

	public function vesselTopConf()
	{
		return View::make('reports/vessel_top_conf')->withAccess($this->access);
	}

	public function vesselTopRpt()
	{
		$year = $this->reportsManager->getYear(Input::get('year'));
		$vessel = $this->reportsManager->getTopVesselByYear($year);

		$vessel_name = $this->reportsManager->convertValuesToArray($vessel, 'name');
		$count = $this->reportsManager->convertValuesToArray($vessel, 'v_count');

		// dd($vessel_name->toJson());
		// dd($count->toJson());

		return View::make('reports/vessel_top_rpt', 
			compact(
				'year','vessel_name', 'count'
		))->withAccess($this->access);	
	}	

	public function vesselTopAgentConf()
	{
		return View::make('reports/agent_top_conf')->withAccess($this->access);
	}

	public function vesselTopAgentRpt()
	{
		$year = $this->reportsManager->getYear(Input::get('year'));
		$agent = $this->reportsManager->getTopAgentByYear('2016');

		$name = $this->reportsManager->convertValuesToArray($agent, 'name');
		$count = $this->reportsManager->convertValuesToArray($agent, 'count');

		// dd($name->toJson());
		// dd($count->toJson());

		return View::make('reports/agent_top_rpt', 
			compact(
				'year','name', 'count'
		))->withAccess($this->access);	
	}

	public function consigneeTopConf()
	{
		return View::make('reports/consignee_top_conf')->withAccess($this->access);
	}

	public function consigneeTopRpt()
	{
		$year = $this->reportsManager->getYear(Input::get('year'));
		$consignees = $this->reportsManager->getTopConsigneeByYear($year);

		// dd($consignees->toArray());
		return View::make('reports/consignee_top_rpt', 
			compact(
				'year',
				'consignees'
		))->withAccess($this->access);			
	}

	public function consignorTopConf()
	{
		return View::make('reports/consignor_top_conf')->withAccess($this->access);
	}

	public function consignorTopRpt()
	{
		$year = $this->reportsManager->getYear(Input::get('year'));
		$consignors = $this->reportsManager->getTopConsignorByYear($year);

		// dd($consignors->toArray());
		return View::make('reports/consignor_top_rpt', 
			compact(
				'year',
				'consignors'
		))->withAccess($this->access);		
	}
	

}