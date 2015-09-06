<?php

namespace LLPM\WorkOrders;

use Illuminate\Support\MessageBag;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\WorkOrderRepository;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class AttachedContainersToWorkOrderCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $containerRepository;

    protected $messages;
	protected $registeredContainers = [];
    protected $workOrderRepository;

	function __construct(
        ContainerRepository $containerRepository, 
        MessageBag $messages, 
        WorkOrderRepository $workOrderRepository
    )
	{
		$this->containerRepository = $containerRepository;
        $this->messages = $messages;
        $this->workOrderRepository = $workOrderRepository;
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
        $workOrder = $this->workOrderRepository->getById($command->workorder_id);
        
        $ccp = json_decode($workOrder->who_is_involved);
        $to_confirm_by = $ccp[0];
        $check_point = 1;

        foreach ($command->containers as $key => $value) {

            // by default, $value is container_id
            $container_id = $value;

            // only in ST
            if($workOrder->movement == 'ST') {
                $container_id = $key;
                $cargoes_id = $value;
            }
        
            $ctn = $this->containerRepository->getById($container_id);

            // attach containers to workorder
            $workOrder->containers()->attach($ctn->id, ['movement' => $workOrder->movement,'content' => $ctn->content]);             

            // update container's current_movement with this workorder no
            $ctn->current_movement = $workOrder->workorder_no;
            $ctn->to_confirm_by = $to_confirm_by;
            $ctn->check_point = $check_point;

            if($workOrder->movement == 'HE') {
                $ctn->export_vessel_schedule_id = $workOrder->vessel_schedule_id;
            }

            if($workOrder->movement == 'ST') {
                $ctn->pre_stuffing = $cargoes_id;
            }

            $ctn->save();
        }

        return $workOrder;
    }
}