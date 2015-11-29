<?php

namespace LLPM\Confirmation;

use App;
use Auth;
use Carbon\Carbon;
use Container;
use ContainerConfirmation;
use LLPM\Repositories\CargoRepository;
use LLPM\Repositories\ContainerConfirmationProcessRepository;
use LLPM\Repositories\ContainerConfirmationRepository;
use LLPM\Repositories\ContainerRepository;
use LLPM\Repositories\ContainerWorkorderConfirmationRepository;
use LLPM\Repositories\WorkOrderRepository;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;

class ConfirmContainerCommandHandler implements CommandHandler
{
    use DispatchableTrait;

    protected $workOrderRepository;
    protected $containerRepository;
    protected $cargoRepository;
    protected $containerConfirmationRepository;
    protected $containerWorkorderConfirmationRepository;
    protected $containerConfirmationProcessRepository;
    protected $idGenerator;

    public function __construct(
        WorkOrderRepository $workOrderRepository, 
        ContainerRepository $containerRepository, 
        CargoRepository $cargoRepository, 
        ContainerConfirmationRepository $containerConfirmationRepository, 
        ContainerWorkorderConfirmationRepository $containerWorkorderConfirmationRepository, 
        ContainerConfirmationProcessRepository $containerConfirmationProcessRepository
    )
    {
        $this->workOrderRepository = $workOrderRepository;
        $this->containerRepository = $containerRepository;
        $this->cargoRepository = $cargoRepository;
        $this->containerConfirmationRepository = $containerConfirmationRepository;
        $this->containerWorkorderConfirmationRepository = $containerWorkorderConfirmationRepository;
        $this->containerConfirmationProcessRepository = $containerConfirmationProcessRepository;
    }

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */

    // public 'confirmationId' =>
    //   array (size=4)
    //     0 => string '4-L-124569-HI' (length=8) [container_id]-[content]-[workorder_no]-[movement]
    //     1 => string '1-L-124569-HI' (length=8)
    //     2 => string '2-L-124569-HI' (length=8)
    //     3 => string '11-L-124569-HI' (length=9)

    public function handle($command)
    {
        // dd($command);

        $confirmationIds = [];
        $roles = [];

        $a_cons = json_decode($command->a_confirmation);
        $a_car = json_decode($command->a_carrier);
        $a_lif = json_decode($command->a_lifter);
        $operator = $this->getOperator($command);
        $confirmed_at = $this->getTime($command);

        // dd($a_ope);

        foreach ($a_cons as $key => $confirmation) {
            $confirmationIds[] = explode(',', $confirmation);
            $confirmationIds[$key][] = $a_car[$key];
            $confirmationIds[$key][] = $a_lif[$key];
        }

        // dd($confirmationIds);

        //return Auth::user()->id;

        foreach ($confirmationIds as $confirmation) {

            // dd($confirmation);
            // get confirmation details

            // confirm at checkpoint
            $ctn = $this->confirmAtCheckPoint($confirmation, $operator, $confirmed_at);

            // update check point
            $cp = $this->updateCheckPoint($ctn, $confirmation);

            // update the carrier and lifter
            $this->updateVehicleLifter($confirmation);

            if ($cp['role'] != '') {

                if (!array_key_exists($cp['role'], $roles)) {
                    $roles[$cp['role']] = 0;
                }

                $roles[$cp['role']]++;

            }

            // if all check points is not completed, cannot proceed
            if ($cp['complete']) {
                $this->confirmContainer($confirmation, $confirmed_at);

                if ($confirmation[3] == 'ST') {
                    $this->updateSTContainer($confirmation);
                } else {
                    $this->updateContainer($confirmation);
                }

                if ($confirmation[1] == 'L') {
                    // update cargo if the contaner is laden
                    $this->updateCargoes($confirmation);
                }

                if ($confirmation[3] == 'US') {
                    // update cargo if the contaner is laden
                    $this->detachContainer($confirmation);
                }
            }
            //var_dump($confirmation->toArray());
        }

        // foreach ($roles as $role => $count) {
        //     if ($count > 0) {
        //         $this->triggerPusher($role, $confirmationIds);
        //     }
        // }

        //return $confirmation;
    }

    public function getOperator($command)
    {
        // dd($command->a_operator);
        if($command->a_operator === 0) {
            return Auth::user()->id;
        }

        return (int)json_decode($command->a_operator)[0];
    }

    public function getTime($command)
    {
        // dd($command->a_operator);
        if($command->a_confirmed_at == '') {
            return Carbon::now();
        }

        // dd(Carbon::createFromFormat('Y-m-d H:i', json_decode($command->a_date)[0] . ' ' . json_decode($command->a_confirmed_at)[0]));
        return Carbon::createFromFormat('Y-m-d H:i', json_decode($command->a_date)[0] . ' ' . json_decode($command->a_confirmed_at)[0]);

    }
       

    public function triggerPusher($to_confirm_by, $containers)
    {

        $pusher = App::make('Pusher');
        $pusher->trigger('LLPM', $to_confirm_by, json_encode($containers));
    }

    public function confirmAtCheckPoint($confirmation, $operator, $confirmed_at)
    {
        // dd($confirmation);
        $ctn = $this->containerRepository->getById($confirmation[0]);
        // dd($ctn->toArray());

        //save to container_workorder_confirmation
        $this->containerWorkorderConfirmationRepository->confirmationEntry($ctn, $operator, $confirmed_at);

        return $ctn;
    }

    public function updateCheckPoint($ctn, $confirmation)
    {
        // dd($confirmation);
        $cp['complete'] = true;

        $process = $this->containerConfirmationProcessRepository->getProcess($confirmation[3]);
        $next_cp = $ctn->check_point + 1;
        // dd($next_cp);
        // dd($process->{'cp'. ($ctn->check_point + 1)});
        // dd($process->{'cp'. $next_cp});
        if ($ctn->check_point < $process->total_check_points) {
            $to_confirm_by = $process->{'cp' . $next_cp};
            $check_point = $next_cp;
            $cp['complete'] = false;
        } else {
            $to_confirm_by = '';
            $check_point = 0;
        }

        $cp['role'] = $to_confirm_by;

        $ctn->to_confirm_by = $to_confirm_by;
        $ctn->check_point = $check_point;
        $ctn->save();

        // $pusher_data = [
        //  "id"=> $ctn->id . ',' . $ctn->content . ',' . $ctn->current_movement . ',' . $ctn->workorders->last()->movement,
        //  "container_no"=> $ctn->container_no
        // ];
        // // trigger pusher
        // $pusher = App::make('Pusher');
        // $pusher->trigger('LLPM', $to_confirm_by, json_encode($pusher_data));
        // dd($ctn->toArray());
        return $cp;
    }

    public function updateVehicleLifter($confirmation)
    {
        $containerConfirmation = ContainerConfirmation::update_vehicle_lifter(
            $confirmation[0], $confirmation[4], $confirmation[5]
        );

        $containerConfirmation->save();

        return $containerConfirmation;

    }

    public function confirmContainer($confirmation, $confirmed_at)
    {
        $containerConfirmation = ContainerConfirmation::confirm(
            $confirmation[0], 1, Auth::user()->id, $confirmed_at
        );

        $containerConfirmation->save();

        return $containerConfirmation;

    }

    public function updateSTContainer($confirmation)
    {
        $workorder = $this->workOrderRepository->getById($confirmation[2]);
        $ctn = $this->containerRepository->getById($confirmation[0]);

        $cargoes = explode(',', $ctn->pre_stuffing);

        $ctn->content = 'L';
        $ctn->current_movement = 0;
        $ctn->dl_check = 0;
        $ctn->pre_stuffing = '';

        $ctn->save();

        // attach cargo

        foreach ($cargoes as $cargo_id) {
            $cargo = $this->cargoRepository->getById($cargo_id);
            $ctn->cargoes()->attach($cargo);
            $cargo->increment('containerized');
        }
    }

    public function updateContainer($confirmation)
    {
        $workorder = $this->workOrderRepository->getById($confirmation[2]);

        $updateContainer = Container::editAfterConfirmation(
            $confirmation[0],
            $workorder->container_location,
            $workorder->container_status,
            0
        );

        $updateContainer->save();

        return $updateContainer;
    }

    public function updateCargoes($confirmation)
    {
        $container = $this->containerRepository->getById($confirmation[0]);

        //dd($container->toArray());

        foreach ($container->cargoes as $cargo) {
            if ($this->updatable($cargo, $confirmation)) {
                $this->updateCargo($cargo, $confirmation);
            }

        }
    }

    public function updateCargo($cargo, $confirmation)
    {
        if ($confirmation[3] == 'HI' || $confirmation[3] == 'RI-1' || $confirmation[3] == 'RI-3') {
            //update received_by and received_date
            $this->updateCargoReceivedDate($cargo);

        }

        if ($confirmation[3] == 'HE' || $confirmation[3] == 'RO-1' || $confirmation[3] == 'RO-3') {
            //update released_by and released_date
            $this->updateCargoReleasedDate($cargo);

        }

        if ($confirmation[3] == 'US') {
            //update released_by and released_date
            
            if($cargo->dl_no != 0) {

                $this->updateCargoReleasedDate($cargo);

            }
        }

        //dd('updateCargo function');
    }

    public function updateCargoReceivedDate($cargo)
    {
        $cargo->received_by = Auth::user()->id;
        $cargo->received_date = date('Y-m-d H:i:s');
        $cargo->save();      

        $cargo->increment('status');          
    }

    public function updateCargoReleasedDate($cargo)
    {
        $cargo->released_by = Auth::user()->id;
        $cargo->released_date = date('Y-m-d H:i:s');
        $cargo->save();    

        $cargo->increment('status');

    }

    public function updatable($cargo, $confirmation)
    {
        if($confirmation[3] == 'HI' || $confirmation[3] == 'RI-1' || $confirmation[3] == 'RI-3') {
            foreach ($cargo->containers as $container) {
                if($container->status != 3) {
                    return false;
                }
            }    
        }

        if($confirmation[3] == 'HE' || $confirmation[3] == 'RO-1' || $confirmation[3] == 'RO-3') {
            foreach ($cargo->containers as $container) {
                if($container->status != 4) {
                    return false;
                }
            }    
        }

        if($confirmation[3] == 'US') {
            // Why 1? Because the container is still attached to only one container
            if(count($cargo->containers) > 1) {
                return false;
            }
        }

        return true;
    }


    // public function updatable($cargo, $confirmation)
    // {
    //     foreach ($cargo->containers as $container) {

    //         // this is to accomodate container that has not been issued workorder yet
    //         // this is only applicable to Receiving (RI-1. RI-3) and Haulage Import (HI)
    //         if (count($container->workorders) == 0) {
    //             return false;
    //         }

    //         $movement = $container->workorders->last()->pivot->movement;
    //         $confirmed = $container->workorders->last()->pivot->confirmed;

    //         if($movement == 'HI' || $movement == 'RI-1' || $movement == 'RI-3') {
    //             // this is only applicable to Receiving (RI-1. RI-3) and Haulage Import (HI)
    //             if ($confirmed == 0) {
    //                 return false;
    //             }                
    //         }

    //         if($movement == 'US') {
    //             // this is only applicable to Receiving (RI-1. RI-3) and Haulage Import (HI)
    //             if ($container->workorders->last()->pivot->confirmed == 0) {
    //                 return false;
    //             }                
    //         }
    //     }

    //     return true;
    // }

    public function detachContainer($confirmation)
    {
        $container = $this->containerRepository->getById($confirmation[0]);

        //dd($container->toArray());

        foreach ($container->cargoes as $cargo) {
            $cargo->containers()->detach($container);
            $cargo->containerized = 0;
            $cargo->save();

        }

        $container->content = "E";
        $container->save();
    }
}
