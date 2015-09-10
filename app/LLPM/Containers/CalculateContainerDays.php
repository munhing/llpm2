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

        // filter out workorders that are not confirmed yet
        $valid_workorders = $this->filterWorkorders($workorders);

        $total_workorders = count($valid_workorders);

        $days['L'] = 0;
        $days['E'] = 0;
        $days['total'] = Carbon::createFromFormat('Y-m-d', $valid_workorders[0]->pivot->updated_at->format('Y-m-d'))->diffInDays() + 1;

        echo 'Valid Workorders: ' . "\n" . json_encode($valid_workorders) . "\n" . "\n";
        echo 'Total Workorders: ' . json_encode($total_workorders) . "\n" . "\n";


        for($i=0; $i<$total_workorders; $i++) {

            echo 'Workorder #: ' . $valid_workorders[$i]->id . "\n" . "\n";

            // reason for creating a new carbon so that it will capture the date and not the time.
            // Carbon diffInDays() compute 0 if less than 24 hours
            $fromDate = Carbon::createFromFormat('Y-m-d', $valid_workorders[$i]->pivot->updated_at->format('Y-m-d'));

            $movement = $valid_workorders[$i]->pivot->movement;

            $content = $valid_workorders[$i]->pivot->content;

            if($movement == 'US') {
                $content = 'E';
            } elseif($movement == 'ST') {
                $content = 'L';
            }


            if($i+1 == $total_workorders) {
                $toDate = Carbon::now();
            } else {
                $toDate = Carbon::createFromFormat('Y-m-d', $valid_workorders[$i+1]->pivot->updated_at->format('Y-m-d'));
            }

            $diffDays = $fromDate->diffInDays($toDate);

            // if this is the last workorder, then add 1 day
            // if the next workorder is US/ST, then have to add 1 day
            if($i+1 == $total_workorders) {
                $diffDays += 1;
            } else {
                $next_movement = $valid_workorders[$i+1]->pivot->movement;
         
                if($next_movement == 'US' || $next_movement == 'ST'){
                    $diffDays += 1;
                }
            }

            $days[$content] += $diffDays;

            echo 'FromDate : ' . $fromDate . "\n" . "\n";
            echo 'ToDate : ' . $toDate . "\n" . "\n";
            echo 'movement : ' . $movement . "\n" . "\n";
            echo 'Content : ' . $content . "\n" . "\n";
        }

        return $days;
	}

    public function filterWorkorders($workorders)
    {
        $valid_workorders = [];

        foreach($workorders as $workorder) {
            if($workorder->pivot->confirmed == 0) {
                continue;
            }

            $valid_workorders[] = $workorder;
        }

        return $valid_workorders;
    }
}