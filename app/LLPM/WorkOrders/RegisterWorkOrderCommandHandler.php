<?php 

namespace LLPM\WorkOrders;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\WorkOrderRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\ContainerConfirmationProcessRepository;
use LLPM\IdGenerator;
use WorkOrder;
use App;
use LLPM\WorkOrders\AttachedContainersToWorkOrderCommandHandler;

class RegisterWorkOrderCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $workOrderRepository;
    protected $containerRepository;
	protected $containerConfirmationProcessRepository;
	protected $idGenerator;
    protected $attachedContainersToWorkOrder;

	function __construct(
        WorkOrderRepository $workOrderRepository, 
        ContainerRepository $containerRepository, 
        IdGenerator $idGenerator, 
        ContainerConfirmationProcessRepository $containerConfirmationProcessRepository,
        AttachedContainersToWorkOrderCommandHandler $attachedContainersToWorkOrder
    )
	{
		$this->workOrderRepository = $workOrderRepository;
        $this->containerRepository = $containerRepository;
		$this->containerConfirmationProcessRepository = $containerConfirmationProcessRepository;
		$this->idGenerator = $idGenerator;
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
        // $this->updateContainers($command, $workOrder);

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
        $workorder_no = $this->idGenerator->generateWorkOrderNo();
        $container_location = $this->getLocation($command);
        $container_status = $this->getStatus($command);
        $who_is_involved = $this->getInvolvement($command->type);

        $workOrder = WorkOrder::register(
            $workorder_no, 
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

    // function updateContainers($command, $workOrder)
    // {
    //     $ccp = json_decode($workOrder->who_is_involved);
    //     $to_confirm_by = $ccp[0];
    //     $check_point = 1;

    //     foreach ($command->containers as $key => $value) {

    //         // by default, $value is container_id
    //         $container_id = $value;

    //         // only in ST
    //         if($command->type == 'ST') {
    //             $container_id = $key;
    //             $cargoes_id = $value;
    //         }
        
    //         $ctn = $this->containerRepository->getById($container_id);

    //         // attach containers to workorder
    //         $workOrder->containers()->attach($ctn->id, ['movement' => $workOrder->movement,'content' => $ctn->content]);             

    //         // update container's current_movement with this workorder no
    //         $ctn->current_movement = $workOrder->workorder_no;
    //         $ctn->to_confirm_by = $to_confirm_by;
    //         $ctn->check_point = $check_point;

    //         if($command->type == 'HE') {
    //             $ctn->export_vessel_schedule_id = $command->carrier_id;
    //         }

    //         if($command->type == 'ST') {
    //             $ctn->pre_stuffing = $cargoes_id;
    //         }

    //         $ctn->save();               
    //     }

    //     //$this->dispatchEventsFor($workOrder);
    //     // $this->triggerPusher($to_confirm_by, $command->containers);
    // }

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