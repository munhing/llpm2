<?php namespace LLPM\WorkOrders;

use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use LLPM\Repositories\WorkOrderRepository;
use LLPM\Repositories\ContainerRepository;

class CancelContainerCommandHandler implements CommandHandler {

	use DispatchableTrait;

	protected $workOrderRepository;
	protected $containerRepository;

	function __construct(WorkOrderRepository $workOrderRepository, ContainerRepository $containerRepository)
	{
		$this->workOrderRepository = $workOrderRepository;
		$this->containerRepository = $containerRepository;
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

        //detach container from workorder
        $workorder = $this->workOrderRepository->cancelContainer($command->workorder_id, $command->container_id);

        //update containers.current_movement = 0
        if($workorder) {
            $container = $this->updateContainer($command->container_id);
        }
		
		return $container;    	
    }

    function updateContainer($container_id)
    {
        $container = $this->containerRepository->getById($container_id);
        $container->current_movement = 0;
        $container->save();

        return $container;
    }

}