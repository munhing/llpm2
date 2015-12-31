<?php

use LLPM\Repositories\CargoRepository;

use LLPM\CargoConfirmation\CargoConfirmationCommand;
use LLPM\CargoConfirmation\CargoExportConfirmationCommand;

class CargoConfirmationController extends \BaseController {

	protected $cargoRepository;

	function __construct(CargoRepository $cargoRepository)
	{
		$this->cargoRepository = $cargoRepository;
	}

	/**
	 * Display a listing of the resource.
	 * GET /cargoconfirmation
	 *
	 * @return Response
	 */
	public function indexImport()
	{

		$cargoes = $this->cargoRepository->getImportLooseCargoWithStatus1And3();

        // foreach($cargoes as $crg) {

        //     var_dump($crg->importSchedule->vessel);
        // }

        // die();

		return View::make('cargo_confirmation/index', compact('cargoes'));		
	}


	public function indexExport()
	{
		// return "CargoConfiration";
		$cargoes = $this->cargoRepository->getExportLooseCargoWithStatus2And3();

        // foreach($cargoes as $crg) {

        //     var_dump(DB::getQueryLog());
        //     var_dump($crg->exportSchedule);
        // }


        // die();

		return View::make('cargo_confirmation/cargo_export', compact('cargoes'));		
	}


	public function updateImport()
	{
		//dd(Input::all());

		$input = Input::all();

		if(! isset($input['confirmationId'])) {

			Flash::error("No cargoes selected!");
			return Redirect::back();			
		}

		$this->execute(CargoConfirmationCommand::class, $input);

		Flash::success('Confirmation successful!');

		return Redirect::route('cargo.confirmation.import');		
	}

	public function updateExport()
	{
		//dd(Input::all());

		$input = Input::all();

		if(! isset($input['confirmationId'])) {

			Flash::error("No cargoes selected!");
			return Redirect::back();			
		}

		//dd('Stop');

		$this->execute(CargoExportConfirmationCommand::class, $input);

		Flash::success('Confirmation successful!');

		return Redirect::route('cargo.confirmation.export');		
	}	
	/**
	 * Show the form for creating a new resource.
	 * GET /cargoconfirmation/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /cargoconfirmation
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /cargoconfirmation/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /cargoconfirmation/{id}/edit
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
	 * PUT /cargoconfirmation/{id}
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
	 * DELETE /cargoconfirmation/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}