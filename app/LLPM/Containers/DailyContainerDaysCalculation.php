<?php

namespace LLPM\Containers;

use Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use LLPM\Containers\CalculateContainerDays;
use LLPM\Repositories\ContainerRepository;

class DailyContainerDaysCalculation
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
        
        // $containers = $this->containerRepository->getSpecificContainer();

        // 2. Loop each container
        foreach($containers as $container) {

            // 3. Calculate container's days empty and laden
            // this need to create a command of it's own because there will be other class needing this
            // {"L":11,"E":0,"total":11}
            Log::info("Calculating container#: $container->container_no");

            $days = $this->calculateContainerDays->fire($container);

            // dd($days);

            Log::info(" => Done, updating to database...");
            
            // 4. Update DB
            $this->containerRepository->updateDays($container->id, $days);
            Log::info(" => Updated! \n");
        }
        

   	
	}    
}