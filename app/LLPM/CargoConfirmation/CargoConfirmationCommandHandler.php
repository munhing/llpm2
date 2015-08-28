<?php namespace LLPM\CargoConfirmation;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

use LLPM\Repositories\CargoRepository;
use Cargo;
use Carbon\Carbon;
use Auth;

class CargoConfirmationCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $cargoRepository;

	function __construct(CargoRepository $cargoRepository)
	{
		$this->cargoRepository = $cargoRepository;
	}

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {
    	
    	//dd($command);
    	
    	foreach($command->confirmationId as $cargo_id)
    	{
    		$cargo = $this->cargoRepository->getById($cargo_id);

    		if($cargo->status == 1) {
    			$column_by = 'received_by';
    			$column_date = 'received_date';
    		} elseif ($cargo->status == 3) {
     			$column_by = 'released_by';
    			$column_date = 'released_date';   			
    		}

    		$cargo->increment('status');

    		$cargo->$column_by = Auth::user()->id;
    		$cargo->$column_date = Carbon::now();

    		$cargo->save();
    	}
	}
}