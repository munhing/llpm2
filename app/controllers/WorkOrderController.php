<?php

use LLPM\Repositories\WorkOrderRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\ImportContainerRepository;
use LLPM\Repositories\VesselScheduleRepository;
use LLPM\Repositories\PortUserRepository;
use LLPM\Repositories\ContainerConfirmationRepository;
use LLPM\Repositories\CargoRepository;

use LLPM\WorkOrders\RegisterWorkOrderCommand;
use LLPM\WorkOrders\CancelContainerCommand;

class WorkOrderController extends \BaseController {

	protected $workOrderRepository;
	protected $containerRepository;
	protected $importContainerRepository;
	protected $vesselScheduleRepository;
	protected $portUserRepository;
	protected $containerConfirmationRepository;
	protected $cargoRepository;

	function __construct(WorkOrderRepository $workOrderRepository, ContainerRepository $containerRepository, ImportContainerRepository $importContainerRepository, VesselScheduleRepository $vesselScheduleRepository, PortUserRepository $portUserRepository, ContainerConfirmationRepository $containerConfirmationRepository, CargoRepository $cargoRepository)
	{
		$this->workOrderRepository = $workOrderRepository;
		$this->containerRepository = $containerRepository;
		$this->importContainerRepository = $importContainerRepository;
		$this->vesselScheduleRepository = $vesselScheduleRepository;
		$this->portUserRepository = $portUserRepository;
		$this->containerConfirmationRepository = $containerConfirmationRepository;
		$this->cargoRepository = $cargoRepository;
	}

	/**
	 * Display a listing of the resource.
	 * GET /workorder
	 *
	 * @return Response
	 */
	public function index()
	{

		if(Input::get('view_date')) {
			Session::put('workorder.date', Input::get('view_date'));
		}

		if(!Session::get('workorder.date')) {
			Session::put('workorder.date', date('m/Y'));
		}

		$workorders = $this->workOrderRepository->getAllByMonth(convertMonthToMySQLDate(Session::get('workorder.date')));
		return View::make('workorders/index', compact('workorders'));

	}

	/**
	 * Show the form for creating a new resource.
	 * GET /workorder/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//$handlers = $this->portUserRepository->getAll();
		//dd('Hello');
		return View::make('workorders/create');
	}

	public function carrierList()
	{
		$type = Input::get('type');

		//$type = 'HI';

		switch ($type) 
		{
			case "HI":
			case "HE":
				$carrierList = $this->vesselScheduleRepository->getActiveSchedule();
				break;
			default:
				$carrierList = $this->portUserRepository->getAll();
		}

		//dd($carrierList->toArray());

		return json_encode($carrierList);

	}

	public function handlerList()
	{
		$q = Input::get('q');
		$handlers= [];

		if ($q) {
			$handlers = $this->portUserRepository->searchByName($q);	
		}

		//dd($handlers);

		return json_encode($handlers);

		/* // Sample json data
		[{"id":2701,"text":"MASTER OF TENAGA TIGA"},{"id":41,"text":"MERIDIAN TENAGA S\/B"},{"id":5,"text":"NAGA SHIPPING & TRADING"},{"id":158,"text":"NAGANURI AUTOMOBILE"},{"id":379,"text":"PEMBORONG SERI TENAGA"},{"id":2334,"text":"PENAGA ORBIT S\/B"},{"id":538,"text":"TENAGA M E C(S) S\/B"},{"id":1438,"text":"TENAGA ORBIT S\/B"}]
		*/
	}

	public function containerList()
	{

		$type = Input::get('type');
		$carrier_id = Input::get('carrier_id');
		$containerList= [];

		$movement = explode('-', $type);

		// dd($movement);
		// $type = 'RO';
		// $carrier_id = 502;

		switch ($movement[0]) 
		{
			case "HI":
				$containerList = $this->containerRepository->getWithScheduleId($carrier_id);
				break;
			case "HE":
				$containerList = $this->containerRepository->getHEForStatus(3,1);
				break;					
			case "RI":
				$containerList = $this->containerRepository->getForStatus(2);
				break;	
			case "RO":
				$containerList = $this->containerRepository->getROForStatus(3, $movement[1]);
				break;				
			case "TF":				
				$containerList = $this->containerRepository->getForStatus(3,$movement[1]);
				break;					
		}

		return json_encode($containerList);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /workorder
	 *
	 * @return Response
	 */
	public function store()
	{
	
/* 		'type' => string 'HI' (length=2)
		'handler_id' => string '67' (length=2)
		'carrier_id' => string '354' (length=3)
		'containers' => 
			array (size=3)
				0 => string '4' (length=1)
				1 => string '5' (length=1)
				2 => string '7' (length=1) */
	  

		$input = Input::all();

		if(! $input['containers']) {

			Flash::error("Please key in correctly!");
			return Redirect::back();			
		}

		$workorder = $this->execute(RegisterWorkOrderCommand::class, $input);

		Flash::success("Work Order $workorder->workorder_no successfully registered!");

		return Redirect::route('workorders');		
	}

	/**
	 * Display the specified resource.
	 * GET /workorder/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		$workOrder = $this->workOrderRepository->getDetailsById($id);

		// if($workOrder->movement == 'HI' || $workOrder->movement == 'HE') {
		// 	$carrier = 
		// }

		//dd($workOrder);
		//$containersConfirmation = $this->containerConfirmationRepository->getByWorkOrderId($id);

		//dd($workOrder->containers->toArray());

		//dd($containersConfirmation->first()->container->container_no);
		return View::make('workorders/show', compact('workOrder'));
	}

	public function generate_workorder($id)
	{

		$workOrder = $this->workOrderRepository->getDetailsById($id);
		$handler = $this->portUserRepository->getById($workOrder->handler_id);

		if($workOrder->movement == 'HI') {
			$carrierObj = $this->vesselScheduleRepository->getById($workOrder->vessel_schedule_id);
			$carrier = $carrierObj->vessel->name . ' v.' . $carrierObj->voyage_no_arrival;

		} elseif($workOrder->movement == 'HE') {
			$carrierObj = $this->vesselScheduleRepository->getById($workOrder->vessel_schedule_id);
			$carrier = $carrierObj->vessel->name . ' v.' . $carrierObj->voyage_no_departure;

		} else {
			$carrier = $this->portUserRepository->getById($workOrder->carrier_id)->name;
		}

		// dd($carrierObj->vessel->name);
		// dd($carrier);

		$movement['HI'] = 'Haulage Import';
		$movement['HE'] = 'Haulage Export';
		// $movement['RI-1'] = 'Remove In (CY1)';
		$movement['RI-1'] = 'Remove In to CY1';
		$movement['RI-3'] = 'Remove In to CY3';
		// $movement['RI-3'] = 'Remove In (CY3)';
		// $movement['RO-1'] = 'Remove Out (CY1)';
		$movement['RO-1'] = 'Remove Out from CY1';
		// $movement['RO-3'] = 'Remove Out (CY3)';
		$movement['RO-3'] = 'Remove Out from CY3';
		$movement['TF-3-1'] = 'Transfer to CY1';
		$movement['TF-1-3'] = 'Transfer to CY3';
		$movement['US'] = 'Unstuffing';
		$movement['ST'] = 'Stuffing';

		$content['E'] = 'Empty';
		$content['L'] = 'Laden';

		//dd($workOrder);
		//$containersConfirmation = $this->containerConfirmationRepository->getByWorkOrderId($id);

		//dd($workOrder->containers->toArray());

		//dd($containersConfirmation->first()->container->container_no);
		return View::make('workorders/generate_workorder', compact('workOrder', 'handler', 'carrier', 'movement', 'content'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /workorder/{id}/edit
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
	 * PUT /workorder/{id}
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
	 * DELETE /workorder/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function cancelContainer($id)
	{

		$input = Input::all();
		$input['workorder_id'] = $id;

		if(! $input['container_id']) {

			Flash::error("There was an error!");
			return Redirect::back();			
		}

		$container = $this->execute(CancelContainerCommand::class, $input);

		Flash::success("Container # $container->container_no has been cancelled!");

		return Redirect::route('workorders.show', $id);
	}

	public function createUnstuffing()
	{
		// get list of laden containers
		$containers = $this->containerRepository->getActiveLadenContainers();
		$handlers = $this->portUserRepository->getAll();
		//$handlers = $this->portUserRepository->getAll();
		//dd($containers->toArray());
		return View::make('workorders/create_unstuffing', compact('containers', 'handlers'));
	}

	public function storeUnstuffing()
	{
		//dd(Input::all());


		$input = Input::all();
		$input['type'] = "US";
		$input['location'] = 1;

		if(! $input['containers']) {

			Flash::error("Please key in correctly!");
			return Redirect::back();			
		}

		$workorder = $this->execute(RegisterWorkOrderCommand::class, $input);

		Flash::success("Work Order $workorder->workorder_no successfully registered!");

		return Redirect::route('workorders');		
	}	

	public function createStuffing()
	{
		$containers = $this->containerRepository->getActiveEmptyContainers();
		$handlers = $this->portUserRepository->getAll();
		$cargoList = $this->cargoRepository->getActiveExportCargoForSelectList();
		//dd($containers->toArray());
		return View::make('workorders/create_stuffing', compact('containers', 'handlers', 'cargoList'));
	}	

	public function storeStuffing()
	{
		//dd(Input::all());
		$input = Input::all();
		$input['type'] = "ST";
		$input['location'] = 1;

		if(! $input['containers']) {

			Flash::error("Please key in correctly!");
			return Redirect::back();			
		}

		$workorder = $this->execute(RegisterWorkOrderCommand::class, $input);

		Flash::success("Work Order $workorder->workorder_no successfully registered!");

		return Redirect::route('workorders');			
	}	
}