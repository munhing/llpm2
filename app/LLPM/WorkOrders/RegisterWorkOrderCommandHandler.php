<?php namespace LLPM\WorkOrders;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\WorkOrderRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\ContainerConfirmationProcessRepository;
use LLPM\IdGenerator;
use WorkOrder;
use App;

class RegisterWorkOrderCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $workOrderRepository;
    protected $containerRepository;
	protected $containerConfirmationProcessRepository;
	protected $idGenerator;

	function __construct(WorkOrderRepository $workOrderRepository, ContainerRepository $containerRepository, IdGenerator $idGenerator, ContainerConfirmationProcessRepository $containerConfirmationProcessRepository)
	{
		$this->workOrderRepository = $workOrderRepository;
        $this->containerRepository = $containerRepository;
		$this->containerConfirmationProcessRepository = $containerConfirmationProcessRepository;
		$this->idGenerator = $idGenerator;
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
		
        // foreach ($command->containers as $container_id => $cargoes_id) {
        //     var_dump($container_id . "=>" . $cargoes_id);
        // }

        //dd($command);

		$date = \Carbon\Carbon::now();
		$carrier_id = $command->carrier_id;
		$vessel_schedule_id = 0;
        $movement = explode('-', $command->type);
		
		if($command->type == 'HI' || $command->type == 'HE') {
			$carrier_id = 0;
			$vessel_schedule_id = $command->carrier_id;
		}
		
    	// generate workorder no
    	$workorder_no = $this->idGenerator->generateWorkOrderNo();
    	$container_location = $this->getLocation($command);
    	$container_status = $this->getStatus($command);

		$workOrder = WorkOrder::register(
			$workorder_no, 
			$command->type, 
			$date,
			$carrier_id, 
			$command->handler_id,
			$vessel_schedule_id,
			$container_location,
			$container_status
		);

		//dd($workOrder->toArray());
		
		$this->workOrderRepository->save($workOrder);

        // check confirmation process
        $ccp = $this->containerConfirmationProcessRepository->getProcess($command->type);
        $to_confirm_by = $ccp->cp1;
        $check_point = 1;

        if($command->type == 'ST') {

            foreach ($command->containers as $container_id => $cargoes_id) {
            
                $ctn = $this->containerRepository->getById($container_id);
                //attach containers to workorder
                $workOrder->containers()->attach($ctn->id, ['content' => $ctn->content]);

                //update container's current_movement with this workorder no
                $this->containerRepository->updateCurrentMovementWithCheckPoint($container_id, $workOrder->workorder_no, $to_confirm_by, $check_point);

                $ctn->pre_stuffing = $cargoes_id;
                $ctn->save();

                // $this->triggerPusher($to_confirm_by, $container_id);
            }

        } else {
	
    		foreach ($command->containers as $container_id) {
    		
                $ctn = $this->containerRepository->getById($container_id);
    			//attach containers to workorder
    			$workOrder->containers()->attach($ctn->id, ['content' => $ctn->content]);

    			//update container's current_movement with this workorder no
    			$this->containerRepository->updateCurrentMovementWithCheckPoint($container_id, $workOrder->workorder_no, $to_confirm_by, $check_point);

                if($command->type == 'HE') {
                    $ctn->export_vessel_schedule_id = $vessel_schedule_id;
                    $ctn->save();
                }

                // $this->triggerPusher($to_confirm_by, $container_id);
    		}
		}
		//$this->dispatchEventsFor($workOrder);
        $this->triggerPusher($to_confirm_by, $command->containers);

		return $workOrder;    	
    }

    function triggerPusher($to_confirm_by, $containers)
    {

        // $pusher_data = [
        //     "id"=> $ctn->id . ',' . $ctn->content . ',' . $ctn->current_movement . ',' . $ctn->workorders->last()->movement,
        //     "container_no"=> $ctn->container_no
        // ];

        $pusher = App::make('Pusher');
        $pusher->trigger('LLPM', $to_confirm_by, json_encode($containers));        
    }

    // function triggerPusher($to_confirm_by, $container_id)
    // {
    //     // get a new instance of $ctn to reflect the latest info on workorders
    //     // if not, $ctn-<workorders->last()->movement will flag "Trying to get property of non-object"

    //     $ctn = $this->containerRepository->getById($container_id);

    //     $pusher_data = [
    //         "id"=> $ctn->id . ',' . $ctn->content . ',' . $ctn->current_movement . ',' . $ctn->workorders->last()->movement,
    //         "container_no"=> $ctn->container_no
    //     ];

    //     $pusher = App::make('Pusher');
    //     $pusher->trigger('LLPM', $to_confirm_by, json_encode($pusher_data));        
    // }

    function getLocation($command)
    {
        $movement = explode('-', $command->type);
    	$location = 0;

    	switch($movement[0]) {

    		case 'HI':
            case 'US':
            case 'ST':                   
    			$location = 1;
    			break;
    		case 'TF':
    			$location = (int) $movement[2];
    			break;    			
    		case 'HE':
    		case 'RO':
    			$location = 0;
    			break;  
    		case 'RI':
    			$location = (int) $movement[1];
    			break;		
    	}

    	return $location;
    }

    function getStatus($command)
    {
    	$movement = explode('-', $command->type);
        $status = 0;

    	switch($movement[0]) {

    		case 'HI':
    		case 'RI':
    		case 'TF':
            case 'US':                      
    		case 'ST':    		    		
    			$status = 3;
    			break;
    		case 'HE':
    		case 'RO':    		
    			$status = 4;
    			break;    			
    	}

    	return $status;
    }

}