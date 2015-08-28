<?php

use LLPM\Repositories\VesselRepository;
use LLPM\Forms\VesselForm;
use LLPM\Vessels\RegisterVesselCommand;


class VesselsController extends \BaseController {

	protected $vesselRepository;
	protected $vesselForm;

	function __construct(VesselRepository $vesselRepository, VesselForm $vesselForm)
	{
		$this->vesselRepository = $vesselRepository;
		$this->vesselForm = $vesselForm;

	}

	/**
	 * Display a listing of the resource.
	 * GET /vessels
	 *
	 * @return Response
	 */
	public function index()
	{
		$vessels = $this->vesselRepository->getAll();
		return View::make('vessels/index', compact('vessels'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /vessels/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('vessels/create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /vessels
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->vesselForm->validate(Input::all());

		$vessel = $this->execute(RegisterVesselCommand::class);

		Flash::success("Vessel $vessel->name has been registered!");

		return Redirect::route('manifest.vessels');
	}

	/**
	 * Display the specified resource.
	 * GET /vessels/{id}
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
	 * GET /vessels/{id}/edit
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
	 * PUT /vessels/{id}
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
	 * DELETE /vessels/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}