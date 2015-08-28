<?php

use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\ContainerConfirmationRepository;

use LLPM\Confirmation\ConfirmContainerCommand;

class ContainerConfirmationController extends \BaseController {

	protected $containerRepository;
	protected $containerConfirmationRepository;

	function __construct(ContainerRepository $containerRepository, ContainerConfirmationRepository $containerConfirmationRepository)
	{
		$this->containerRepository = $containerRepository;
		$this->containerConfirmationRepository = $containerConfirmationRepository;
	}

	/**
	 * Display a listing of the resource.
	 * GET /workorder
	 *
	 * @return Response
	 */
	public function index()
	{
		//$confirmationIds = $this->containerConfirmationRepository->getAll();
		$containers = $this->containerRepository->getContainersToConfirm();

		// foreach($containers as $container) {
		// 	var_dump($container->workorders->last()->toArray());
		// }

		// die();

		return View::make('container_confirmation/index', compact('containers'));

	}

	/**
	 * Show the form for creating a new resource.
	 * GET /workorder/create
	 *
	 * @return Response
	 */
	public function create()
	{

	}

	/**
	 * Store a newly created resource in storage.
	 * POST /workorder
	 *
	 * @return Response
	 */
	public function store()
	{
		
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
	public function update()
	{
		//dd(Input::all());
		$input = Input::all();

		if(! isset($input['confirmationId'])) {

			Flash::error("No containers selected!");
			return Redirect::back();			
		}

		$this->execute(ConfirmContainerCommand::class, $input);

		//dd($confirmation);

		Flash::success('Confirmation successful!');

		return Redirect::route('confirmation');		
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

}