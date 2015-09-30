<?php

use LLPM\Repositories\FeeRepository;

class SettingsController extends \BaseController {

	protected $feeRepository;

	function __construct(
		FeeRepository $feeRepository
	)
	{
		$this->feeRepository = $feeRepository;
	}
	/**
	 * Display a listing of the resource.
	 * GET /settings
	 *
	 * @return Response
	 */
	public function feesIndex()
	{
		// dd('Fees Index');
		$handlingFees = $this->feeRepository->getHandlingFees();
		$storageFees = $this->feeRepository->getStorageFees();


		// dd($handlingFees->first()->effective_date);
		// var_dump($handlingFee);
		// var_dump($storageFee);

		return View::make('settings/fees_index', compact('handlingFees', 'storageFees'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /settings/create
	 *
	 * @return Response
	 */
	public function feesStore()
	{
		dd(Input::all());
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /settings
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /settings/{id}
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
	 * GET /settings/{id}/edit
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
	 * PUT /settings/{id}
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
	 * DELETE /settings/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}