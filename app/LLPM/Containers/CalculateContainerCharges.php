<?php

namespace LLPM\Containers;

use Carbon\Carbon;
use Activity;
use LLPM\Repositories\ContainerRepository;
use LLPM\Containers\CalculateContainerDays;

class CalculateContainerCharges
{

    protected $containerRepository;
    protected $calculateContainerDays;

	function __construct(
        ContainerRepository $containerRepository,
        CalculateContainerDays $calculateContainerDays
    )
	{
        $this->containerRepository = $containerRepository;
        $this->calculateContainerDays = $calculateContainerDays;
	}

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function fire()
    {
        // 1. Obtain all active containers in the port, those with status 3
        $containers = $this->containerRepository->getAllActive();

        // 2. Loop each container
        foreach($containers as $container) {

            // 3. Calculate container's days empty and laden
            // this need to create a command of it's own because there will be other class needing this
            // {"L":11,"E":0,"total":11}
            $days = $this->calculateContainerDays->fire($container);

            echo json_encode($days) . "\n";
            
            // 4. Update DB
            $this->containerRepository->updateDays($container->id, $days);
        }
        

   	
	}    
}