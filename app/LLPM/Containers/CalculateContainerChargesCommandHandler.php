<?php 

namespace LLPM\Containers;

use Carbon\Carbon;
use LLPM\Repositories\ContainerRepository;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class CalculateContainerChargesCommandHandler implements CommandHandler {

    protected $containerRepository;

	use DispatchableTrait;

	function __construct(ContainerRepository $containerRepository)
	{
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
        // 1. Obtain all active containers in the port
        $containers = $this->containerRepository->getAllActive();

        // 2. Loop each container
        foreach($containers as $container) {

            // 3. Calculate container's days empty and laden
            $this->calculate($container);
            
        }
        // 
        // 4. Update DB

   	
	}

    public function calculate($container)
    {
        $days = [];

        $workorders = $container->workorders;
        $total_workorders = count($workorders);

        $days['L'] = 0;
        $days['E'] = 0;
        $days['total'] = Carbon::createFromFormat('Y-m-d', $workorder[0]->pivot->updated_at->format('Y-m-d'))->diffInDays() + 1;

        for($i=0; $i<$total_workorders; $i++) {

            // reason for creating a new carbon so that it will capture the date and not the time.
            // Carbon diffInDays() compute 0 if less than 24 hours
            $fromDate = Carbon::createFromFormat('Y-m-d', $workorder[$i]->pivot->updated_at->format('Y-m-d'));
            // var_dump($fromDate);
            // dd($workorder[$i]->toArray());
            if($i+1 == $count) {
                $toDate = Carbon::now();
            } else {
                $toDate = Carbon::createFromFormat('Y-m-d', $workorder[$i+1]->pivot->updated_at->format('Y-m-d'));
            }
            // var_dump($toDate);
            if($i+1 == $count) {
                $content = $workorder[$i]->pivot->content;
            } else {
                $content = $workorder[$i+1]->pivot->content;
            }

            if($i == 0){
                $diffDays = $fromDate->diffInDays($toDate) + 1;
            } else {
                $diffDays = $fromDate->diffInDays($toDate); 
            }
            
            $days[$content] += $diffDays;
            // var_dump($diffDays);
        }

        // var_dump($days);
        $container->days = $days;
        $ctn[] = $container;        
    }  
}