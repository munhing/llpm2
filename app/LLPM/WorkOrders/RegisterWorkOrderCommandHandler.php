<?php 

namespace LLPM\WorkOrders;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\WorkOrderRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\ContainerConfirmationProcessRepository;
use WorkOrder;
use App;
use LLPM\WorkOrders\AttachedContainersToWorkOrderCommandHandler;

class RegisterWorkOrderCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $workOrderRepository;
    protected $containerRepository;
	protected $containerConfirmationProcessRepository;
    protected $attachedContainersToWorkOrder;

	function __construct(
        WorkOrderRepository $workOrderRepository, 
        ContainerRepository $containerRepository, 
        ContainerConfirmationProcessRepository $containerConfirmationProcessRepository,
        AttachedContainersToWorkOrderCommandHandler $attachedContainersToWorkOrder
    )
	{
		$this->workOrderRepository = $workOrderRepository;
        $this->containerRepository = $containerRepository;
		$this->containerConfirmationProcessRepository = $containerConfirmationProcessRepository;
        $this->attachedContainersToWorkOrder = $attachedContainersToWorkOrder;
	}

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {
        $workOrder = $this->registerWorkOrder($command);

        $command->workorder_id = $workOrder->id;

        $this->attachedContainersToWorkOrder->handle($command);
        
        // calculate storage and handling charges and save it to workorder
        $this->calculateChargesByWorkOrder($workOrder);

		return $workOrder;    	
    }

    function registerWorkOrder($command)
    {
        $date = \Carbon\Carbon::now();
        $carrier_id = $command->carrier_id;
        $vessel_schedule_id = 0;
        $movement = explode('-', $command->type);
        
        if($command->type == 'HI' || $command->type == 'HE') {
            $carrier_id = 0;
            $vessel_schedule_id = $command->carrier_id;
        }
        
        // generate workorder no
        $container_location = $this->getLocation($command);
        $container_status = $this->getStatus($command);
        $who_is_involved = $this->getInvolvement($command->type);

        $workOrder = WorkOrder::register(
            $command->type, 
            $date,
            $carrier_id, 
            $command->handler_id,
            $vessel_schedule_id,
            $container_location,
            $container_status,
            $who_is_involved
        );

        //dd($workOrder->toArray());
        
        $this->workOrderRepository->save($workOrder);

        return $workOrder;    
    }

    function getInvolvement($type)
    {
        $who_is_involved = [];

        $ccp = $this->containerConfirmationProcessRepository->getProcess($type);

        for($i=1;$i<=4;$i++) {

            if(!$ccp->{'cp'.$i}){continue;}

            $who_is_involved[] = $ccp->{'cp'.$i};
        }

        return json_encode($who_is_involved);  
    }

    function triggerPusher($to_confirm_by, $containers)
    {
        $pusher = App::make('Pusher');
        $pusher->trigger('LLPM', $to_confirm_by, json_encode($containers));        
    }

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