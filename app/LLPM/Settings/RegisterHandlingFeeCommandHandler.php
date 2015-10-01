<?php 

namespace LLPM\Settings;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\FeeRepository;
use Fee;

class RegisterHandlingFeeCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $feeRepository;

	function __construct(FeeRepository $feeRepository)
	{
		$this->feeRepository = $feeRepository;
	}


    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {
    	// dd($command);

    	//convert rates to array and then json
    	$rates = [];
    	$rates['20E'] = (int)$command->e20;
    	$rates['20L'] = (int)$command->l20;
    	$rates['40E'] = (int)$command->e40;
    	$rates['40L'] = (int)$command->l40;

    	dd(json_encode($rates));
		// $portUser = Fee::register(
		// 	$command->name
		// );

		// $this->portUserRepository->save($portUser);

		// $this->dispatchEventsFor($portUser);

		// return $portUser;    	
    }

}