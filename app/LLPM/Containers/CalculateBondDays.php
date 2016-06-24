<?php 
namespace LLPM\Containers;

use Carbon\Carbon;
use LLPM\Repositories\ContainerRepository;

class CalculateBondDays
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
        $bond_days['import'] = 0;
        $bond_days['export'] = 0;

        $workorders = $container->workorders->sortBy('id');
        // dd($workorders->toArray());

        $valid_workorders = $this->filterWorkorders($workorders);

       
        // calculate bond days for import & export
        $bond_days['import'] = $this->calculateBondImportDays($valid_workorders);
        $bond_days['export'] = $this->calculateBondExportDays($valid_workorders);

        return $bond_days;
	}

    public function calculateBondImportDays($workorders)
    {
        $proceedToCalculate = false;

        foreach($workorders as $wo) {
            if($wo->movement == 'HI' && $wo->pivot->content == 'L') {
                $proceedToCalculate = true;

                $date_start = $wo->vesselSchedule->eta;
            }
        }

        if($proceedToCalculate) {

            $date_end = Carbon::now();
            
            foreach($workorders as $wo) {
                if($wo->movement == 'US' || $wo->movement == 'RO-1') {
                    $date_end = $wo->pivot->confirmed_at;
                }
            }

            return $this->calculateDays($date_start, $date_end);    
        }

        return 0;
    }

    public function calculateBondExportDays($workorders)
    {
        $proceedToCalculate = false;

        foreach($workorders as $wo) {
            if(($wo->movement == 'RI-1' || $wo->movement == 'ST') && $wo->pivot->content == 'L') {

                $proceedToCalculate = true;
                // dd($wo->vessel_schedule_id);

                $date_start = $wo->pivot->confirmed_at;

            }
        }

        if($proceedToCalculate) {

            $date_end = Carbon::now();
            
            foreach($workorders as $wo) {
                if($wo->movement == 'HE') {
                    $date_end = $wo->pivot->confirmed_at;
                }
            }

            return $this->calculateDays($date_start, $date_end);    
        }

        return 0;
    }

    public function calculateDays($date_start, $date_end)
    {
        $start = Carbon::createFromFormat('Y-m-d H', $date_start->format('Y-m-d') . ' 0');
        $end = Carbon::createFromFormat('Y-m-d H', $date_end->format('Y-m-d') . ' 0');

        return $start->diffInDays($end) + 1;
    }

    // Only list workorders that have been confirmed
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