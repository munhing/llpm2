<?php

use LLPM\Repositories\ContainerRepository;
use Carbon\Carbon;

class ContainerController extends \BaseController {

	protected $containerRepository;

	function __construct(ContainerRepository $containerRepository)
	{
		$this->containerRepository = $containerRepository;
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

			for($i=0;$i<$count;$i++) {

				// reason for creating a new carbon so that it will capture the date and not the time.
				// Carbon diffInDays() compute 0 if less than 24 hours
				$fromDate = Carbon::createFromFormat('Y-m-d', $workorder[$i]->pivot->updated_at->format('Y-m-d'));
				// var_dump($fromDate);
				// dd($workorder[$i]->toArray());
				if($i+1 == $count) {
					$toDate = Carbon::now();
				} else {
					$toDate = Carbon::createFromFormat('Y-m-d', $workorder[$i+1]->pivot->updated_at->format('Y-m-d'));
				}
				// var_dump($toDate);
				if($i+1 == $count) {
					$content = $workorder[$i]->pivot->content;
				} else {
					$content = $workorder[$i+1]->pivot->content;
				}

				if($i == 0){
					$diffDays = $fromDate->diffInDays($toDate) + 1;
				} else {
					$diffDays = $fromDate->diffInDays($toDate);	
				}
				
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
	public function edit($id)
	{
		//
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