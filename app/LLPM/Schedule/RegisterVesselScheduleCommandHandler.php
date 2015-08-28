<?php namespace LLPM\Schedule;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\VesselScheduleRepository;
use VesselSchedule;

class RegisterVesselScheduleCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $vesselScheduleRepository;

	function __construct(VesselScheduleRepository $vesselScheduleRepository)
	{
		$this->vesselScheduleRepository = $vesselScheduleRepository;
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

		$vesselSchedule = VesselSchedule::register(
			$command->vessel_id,
			$command->voyage_no_arrival,
			$command->portuser_id,
			$command->eta,
			$command->etd
		);

		$this->vesselScheduleRepository->save($vesselSchedule);

		$this->dispatchEventsFor($vesselSchedule);

		return $vesselSchedule;
    }

}