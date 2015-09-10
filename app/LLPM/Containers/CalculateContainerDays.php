<?php 
namespace LLPM\Containers;

use Carbon\Carbon;
use LLPM\Repositories\ContainerRepository;

class CalculateContainerDays
{
    protected $containerRepository;

	function __construct(
        ContainerRepository $containerRepository
    )
	{
        $this->containerRepository = $containerRepository;
	}

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function fire($container)
    {
        $days = [];

        $workorders = $container->workorders;
        $total_workorders = $workorders->count();

        $days['L'] = 0;
        $days['E'] = 0;
        $days['total'] = Carbon::createFromFormat('Y-m-d', $workorders[0]->pivot->updated_at->format('Y-m-d'))->diffInDays() + 1;

        for($i=0; $i<$total_workorders; $i++) {

            // reason for creating a new carbon so that it will capture the date and not the time.
            // Carbon diffInDays() compute 0 if less than 24 hours
            $fromDate = Carbon::createFromFormat('Y-m-d', $workorders[$i]->pivot->updated_at->format('Y-m-d'));

            if($i+1 == $total_workorders) {
                $toDate = Carbon::now();
            } else {
                $toDate = Carbon::createFromFormat('Y-m-d', $workorders[$i+1]->pivot->updated_at->format('Y-m-d'));
            }

            // this step is to determine the content is L or E
            // if this is the last workorder, the content is taken from it
            // if not, the content is taken from the next workorder
            if($i+1 == $total_workorders) {
                $content = $workorders[$i]->pivot->content;
            } else {
                $content = $workorders[$i+1]->pivot->content;
            }

            $diffDays = $fromDate->diffInDays($toDate) + 1;

            $days[$content] += $diffDays;
            // var_dump($diffDays);
        }

        return $days;
        
	}    
}