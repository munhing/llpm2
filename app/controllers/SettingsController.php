<?php

use LLPM\Forms\HandlingFeeForm;
use LLPM\Forms\StorageFeeForm;
use LLPM\Repositories\FeeRepository;
use LLPM\Settings\RegisterHandlingFeeCommand;
use LLPM\Settings\UpdateHandlingFeeCommand;
use LLPM\Settings\RegisterStorageFeeCommand;
use LLPM\Settings\UpdateStorageFeeCommand;

class SettingsController extends \BaseController {

	protected $feeRepository;
	protected $handlingFeeForm;
	protected $storageFeeForm;

	function __construct(
		FeeRepository $feeRepository,
		HandlingFeeForm $handlingFeeForm,
		StorageFeeForm $storageFeeForm
	)
	{
		$this->feeRepository = $feeRepository;
		$this->handlingFeeForm = $handlingFeeForm;
		$this->storageFeeForm = $storageFeeForm;
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
		$input = Input::all();
		// dd($input);

		if($input['fee_type'] == 'handling') {

			$this->handlingFeeForm->validate($input);

			if($input['form_action'] == 'update') {
				$this->execute(UpdateHandlingFeeCommand::class);
				Flash::success("Handling fee updated!");
			} else {
				$this->execute(RegisterHandlingFeeCommand::class);
				Flash::success("New handling fee was registered!");
			}

		}

		if($input['fee_type'] == 'storage'){

			$this->storageFeeForm->validate($input);

			if($input['form_action'] == 'update') {
				$this->execute(UpdateStorageFeeCommand::class);
				Flash::success("Storage fee updated!");
			} else {
				$this->execute(RegisterStorageFeeCommand::class);
				Flash::success("New Storage fee was registered!");
			}

		}

		return Redirect::back();
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