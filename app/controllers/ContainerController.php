<?php

use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\ContainerWorkorderConfirmationRepository;
use Carbon\Carbon;

class ContainerController extends \BaseController {

	protected $containerRepository;
	protected $containerWorkorderConfirmationRepository;

	function __construct(
		ContainerRepository $containerRepository,
		ContainerWorkorderConfirmationRepository $containerWorkorderConfirmationRepository
	)
	{
		$this->containerRepository = $containerRepository;
		$this->containerWorkorderConfirmationRepository = $containerWorkorderConfirmationRepository;
	}	
	/**
	 * Display a listing of the resource.
	 * GET /container
	 *
	 * @return Response
	 */
	public function index()
	{
		//dd('List containers in the port');
		$containers = $this->addEmptyLadenDays($this->containerRepository->getAllActive());

		// dd($containers->first()->workorders->first()->pivot->updated_at);
		// dd($containers->first()->toArray());

		return View::make('containers/index', compact('containers'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /container/create
	 *
	 * @return Response
	 */
	public function addEmptyLadenDays($containers)
	{
		$ctn = [];

		// $ctn->container_no = 'hkjhkjh';
		// $ctn->empty = 40;

		// dd($ctn->toArray());


		foreach($containers as $container){
			$workorder = $container->workorders;
			$count = count($workorder);

			// var_dump($container->container_no);

			$days['L'] = 0;
			$days['E'] = 0;
			$days['total'] = Carbon::createFromFormat('Y-m-d', $workorder[0]->pivot->updated_at->format('Y-m-d'))->diffInDays() + 1;


			// this will loop thru each workorders the container has
			// if the container only has 1 workorder, then the calculation is from the confirmation date of the container_workorder to current date

			//

			for($i=0;$i<$count;$i++) {

				// reason for creating a new carbon so that it will capture the date and not the time.
				// Carbon diffInDays() compute 0 if less than 24 hours
				$fromDate = Carbon::createFromFormat('Y-m-d', $workorder[$i]->pivot->updated_at->format('Y-m-d'));

				if($i+1 == $count) {
					$toDate = Carbon::now();
				} else {
					$toDate = Carbon::createFromFormat('Y-m-d', $workorder[$i+1]->pivot->updated_at->format('Y-m-d'));
				}

				// this step is to determine the content is L or E
				// if this is the last workorder, the content is taken from it
				// if not, the content is taken from the next workorder
				if($i+1 == $count) {
					$content = $workorder[$i]->pivot->content;
				} else {
					$content = $workorder[$i+1]->pivot->content;
				}

				// add 1 day if there's only 1 workorder
				// if($i == 0){
				// 	$diffDays = $fromDate->diffInDays($toDate) + 1;
				// } else {
				// 	$diffDays = $fromDate->diffInDays($toDate);	
				// }
				
				$diffDays = $fromDate->diffInDays($toDate) + 1;	
							
				$days[$content] += $diffDays;
				// var_dump($diffDays);
			}

			// var_dump($days);
			$container->days = $days;
			$ctn[] = $container;
		}

		// dd('End');

		return $ctn;
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /container
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /container/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($container_id)
	{
		$container = $this->containerRepository->getById($container_id);

		//dd($container->toArray());

		return View::make('containers/show', compact('container'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /container/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function report()
	{
		$ctnlist = [];
		$processedList = [];

		$ctncons = $this->containerWorkorderConfirmationRepository->getAll();


		foreach($ctncons as $ctncon) {
			$ctnlist[$ctncon->container_no . '-' . $ctncon->container_workorder_id][] = $ctncon;
		}

		foreach($ctnlist as $key => $list) {
			$i=1;
			foreach($list as $cwc) {
				// dd($cwc);
				if($i==1) {
					$processedList[$key]['date'] = $cwc->confirmed_at->format('Y-m-d');
					$processedList[$key]['container_no'] = $cwc->container->container_no;
					$processedList[$key]['size'] = $cwc->container->size;
					$processedList[$key]['content'] = $cwc->containerConfirmation->content;
					$processedList[$key]['workorder_no'] = $cwc->workorder->workorder_no;
					$processedList[$key]['movement'] = $cwc->workorder->movement;
					$processedList[$key]['vehicle'] = $cwc->containerConfirmation->vehicle;
					$processedList[$key]['lifter'] = $cwc->containerConfirmation->lifter;
					$processedList[$key]['confirmed_at'] = $cwc->confirmed_at->format('H:i') . " (" . $cwc->role . ")";
					$processedList[$key]['operator'] = $cwc->operator->name;
					$processedList[$key]['confirmed_by'] = $cwc->user->name;
				}

				if($i>1) {				
					$processedList[$key]['confirmed_at'] .= " - " . $cwc->confirmed_at->format('H:i') . " (" . $cwc->role . ")" ;
					$processedList[$key]['operator'] .= " / " . $cwc->operator->name;
					$processedList[$key]['confirmed_by'] .= " / " . $cwc->user->name;
				}

				// if($i == count($list)) {
				// 	$processedList[$key]['duration'] = $cwc->user->username;	
				// }

				$i++;
			}
		}

		// dd($processedList);
		return View::make('containers/report', compact('processedList'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /container/{id}
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
	 * DELETE /container/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}