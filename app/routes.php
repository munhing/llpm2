<?php

Route::filter('permitted', 'LLPM\Filters\PermittedFilter');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
 */
/*
|--------------------------------------------------------------------------
| Test
|--------------------------------------------------------------------------
 */
Route::get('/create_admin_user', function () {

    if (!$munhing = User::where('username', 'admin')->first()) {
        var_dump('Creating username admin...');
        $munhing = User::create([
            'username' => 'admin',
            'email' => 'munhing1980@gmail.com',
            'password' => Hash::make('admin'),
        ]);
    } else {
        var_dump('admin already registered!');
    }

    if (!$admin = Role::where('role', 'ADMINISTRATOR')->first()) {
        var_dump('Creating ADMINISTRATOR Role...');
        $admin = Role::create([
            'role' => 'ADMINISTRATOR',
        ]);
    } else {
        var_dump("ADMINISTRATOR Role already registered!");
    }

    if (!$munhing->roles->contains($admin->id)) {
        var_dump('Adding admin role to munhing');
        $munhing->roles()->attach($admin);
    } else {
        dd('I am already an admin');
    }

});

Route::get('/excel', function () {

    Excel::load('custome_tariff_01.xls', function($reader) {

        $results = $reader->take(20);

        $results->each(function($sheet) {
            var_dump($sheet->header);
        });

    });    




  
});

Route::get('/pusher', function () {

    $pusher_data = [
        "id" => "4,L,123456,HI",
        "container_no" => "ABAB1231234",
    ];

    $pusher = App::make('Pusher');
    $pusher->trigger('LLPM', 'CY1', json_encode($pusher_data));

    // $pusher_var = Config::get('services.pusher');
    // dd($pusher_var['key']);

    // return View::make('mobile/home', compact('pusher_var'));
});

Route::get('/ctnreport', function () {
    // dd('Container Report');
    $ctnlist = [];
    $ctn = ContainerWorkorderConfirmation::all();

    foreach($ctn as $con) {
        $ctnlist[$con->container_id][] = $con->toArray();
    }

    foreach($ctnlist as $c) {

    }

    dd($ctnlist);

});

Route::get('/log', function () {

    Activity::log('Some activity that you wish to log');
});

Route::get('/queue', function () {

    Queue::push(function($job){
    
        Log::info("Queues are cool!");

        $job->delete();
    
    });
});

Route::get('/test', function () {

    $time = '21:56';

    $dt = Carbon\Carbon::createFromFormat('H:i', $time);

    dd($dt);


    // $feeRepo = new LLPM\Repositories\FeeRepository;
    // $fee = json_decode($feeRepo->getHandlingFee(), true);

    // $a = ["20E"=>60, "20L"=>120];

    // $calculation = App::make('LLPM\WorkOrders\CalculateChargesByWorkOrder');

    // $woRepo = new LLPM\Repositories\WorkOrderRepository;

    // $wo = $woRepo->getById(256324);

    // $chr = $calculation->fire($wo);

    // dd($fee);

    // $containerConfirmationProcessRepository = new LLPM\Repositories\ContainerConfirmationProcessRepository;

    // $ccp = $containerConfirmationProcessRepository->getProcess('RI-1');

    // $who_is_involved = [];

    // for($i=1;$i<=4;$i++) {

    //     if(!$ccp->{'cp'.$i}){continue;}

    //     $who_is_involved[] = $ccp->{'cp'.$i};
    // }

    // $json = json_encode($who_is_involved);

    // $arr = json_decode($json);

    // dd(in_array('PB', $arr));

    // $ctn = $ctnRepo->getById(2);

    // $pusher_data = [
    //     "id" => $ctn->container_no,
    // ];

    // // $pusher_data = [
    // //     "id"=> $ctn->id . ',' . $ctn->content . ',' . $ctn->current_movement . ',' . $ctn->workorders->last()->movement,
    // //     "container_no"=> $ctn->container_no
    // // ];

    // dd($pusher_data);

    // $movement = 'HE';

    // $movement_array = explode('-', $movement);

    // var_dump($movement_array);
    // dd(count($movement_array));

    // $cargo = cargo::find(9);

    // dd(count($cargo->containers));

    // $container = Container::find(23);

    // dd(count($container->cargoes));

    //dd(App::make('countryList')->toArray());
    //dd(Config::get('countryList.list.MY'));
    // App::make('LLPMValidator', [1]);
    //dd($errors);
    // $ctn = Container::find(4);
    // dd($ctn->workorders()->updateExistingPivot(1,['confirm'=>1, 'confirm_by'=>1]));

    // $cargo = Cargo::with('m_containers')->find(1);
    // $container = Container::find(1);

    // //var_dump($cargo);
    // //var_dump($container);

    // dd($cargo->m_containers);

    // $ctn = Container::all();

    // var_dump($ctn->first()->cargoes->toArray());

    // $list = ContainerConfirmation::selectRaw('container_workorder.*, containers.container_no, workorders.workorder_no, workorders.movement')
    //                              ->join('containers','container_workorder.container_id','=','containers.id')
    //                              ->join('workorders','container_workorder.workorder_id','=','workorders.id')
    //                              ->where('workorders.movement','HI')
    //                              ->get();
    // dd($list->lists('container_no', 'id'));

    //date_default_timezone_set('Asia/Kuala_Lumpur');
    // dd(date_default_timezone_get() . " " . date('h:i:s'));
    // dd(date('h:i:s'));

    // $faker = Faker\Factory::create();

    // $date = $faker->dateTimeThisYear()->format('Y-m-d');

    // $date = Carbon\Carbon::now()->format('Y-m-d');
    // dd($date);
    // //dd($date);
    // $date2 = Carbon\Carbon::createFromFormat('Y-m-d', $date)->addDays($faker->randomDigit);

    //  dd($date . " - " .$date2->format('Y-m-d'));

    //dd(Vessel::orderBy(DB::raw('RAND()'))->first()->id);
    // 'portuser_id' => PortUser::orderBy(DB::raw('RAND()'))->first()->id,
    // 'voyage_no_arrival' => $faker->dateTimeThisYear(),

    //echo convertToMySQLDate('3/1/2010');
    //return URL::current();
    //return Route::getName();
    // $user = User::first();
    // return $user->getKeyName();

    // $munhing = User::find(1);
    // $admin = Role::find(1);

    // if (!$munhing->roles->contains($admin->id)) {
    //     var_dump('Adding admin role to munhing');
    //     $munhing->roles()->attach($admin);
    // } else {
    //  dd('I am already an admin');
    // }

    // $ctnRepo = new LLPM\Repositories\ImportContainerRepository;
    // $crgRepo = new LLPM\Repositories\ImportCargoRepository;

    // $ctn = $ctnRepo->getByContainerNoAndScheduleId('TCIU4443332', '246');
    // $crg = $crgRepo->getByBlNo('BMTLBU140000005');

    // //dd($crg->toArray());

    // if (!$ctn->importCargoes->contains($crg->id)) {
    //  var_dump('Attaching...');
    //     //$ctn->importCargoes()->attach($crg->id);
    //     $crg->importContainers()->attach($ctn);
    // } else {
    //  var_dump('Attached');
    // }

    // $admin = User::find(2);
    // $admin->roles()->attach(1);

    // $joe = User::find(3);
    // $joe->roles()->attach(2);

    // $admin = Role::find(1);
    // $admin->permissions()->attach(4);
    // $admin->permissions()->attach(5);
});

/*
|--------------------------------------------------------------------------
| Sessions
|--------------------------------------------------------------------------
 */
Route::get('/', function () {
    // return View::make('pages/guest');
    return Redirect::route('home');
});

Route::get('login', [
    'as' => 'login',
    'uses' => 'SessionsController@login',
]);

Route::post('login', [
    'as' => 'login',
    'uses' => 'SessionsController@store',
]);

Route::get('reset', [
    'as' => 'reset',
    'uses' => 'SessionsController@reset',
]);

Route::post('reset', [
    'as' => 'reset',
    'uses' => 'SessionsController@postReset',
]);

Route::get('logout', [
    'as' => 'logout',
    'uses' => 'SessionsController@destroy',
]);

Route::get('secret_register', [
    'as' => 'secret_register',
    'uses' => 'UsersController@secretRegister',
]);

Route::post('secret_register', [
    'as' => 'secret_register',
    'uses' => 'UsersController@store',
]);

/*
|--------------------------------------------------------------------------
| Password Reset
|--------------------------------------------------------------------------
 */

Route::controller('password', 'RemindersController');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
 */

Route::group(['prefix' => 'admin', 'before' => 'auth'], function () {

    Route::get('/', [
        'as' => 'home',
        'uses' => function () {
            return View::make('dashboard');
        },
    ]);


/*
|--------------------------------------------------------------------------
| Admin | Access Control
|--------------------------------------------------------------------------
 */
    // Route::group(['prefix' => 'access', 'before' => ['auth', 'permitted']], function() {

    Route::group(['prefix' => 'access'], function () {

        Route::get('users', [
            'as' => 'users',
            'uses' => 'UsersController@index',
        ]);

        Route::get('users/register', [
            'as' => 'register',
            'uses' => 'UsersController@create',
        ]);

        Route::post('users/register', [
            'as' => 'register',
            'uses' => 'UsersController@store',
        ]);

        Route::get('roles', [
            'as' => 'roles',
            'uses' => 'UsersController@indexRole',
        ]);

        Route::get('roles/create', [
            'as' => 'roles.create',
            'uses' => 'UsersController@createRole',
        ]);

        Route::post('roles/create', [
            'as' => 'roles.create',
            'uses' => 'UsersController@storeRole',
        ]);

        Route::get('permissions', [
            'as' => 'permissions',
            'uses' => 'UsersController@indexPermission',
        ]);

        Route::get('find', [
            'as' => 'users.find',
            'uses' => 'UsersController@getUsersByRole',
        ]); 

        Route::post('check_auth', [
            'as' => 'users.auth',
            'uses' => 'UsersController@checkAuth',
        ]);     

        Route::get('profile', [
            'as' => 'profile',
            'uses' => 'UsersController@profile',
        ]);                    
    });

/*
|--------------------------------------------------------------------------
| Admin | Manifest
|--------------------------------------------------------------------------
 */

    Route::group(['prefix' => 'manifest'], function () {

        Route::any('schedule', [
            'as' => 'manifest.schedule',
            'uses' => 'VesselScheduleController@index',
        ]);

        Route::get('schedule/create', [
            'as' => 'manifest.schedule.create',
            'uses' => 'VesselScheduleController@create',
        ]);

        Route::post('schedule/create', [
            'as' => 'manifest.schedule.create',
            'uses' => 'VesselScheduleController@store',
        ]);

        Route::get('vessels', [
            'as' => 'manifest.vessels',
            'uses' => 'VesselsController@index',
        ]);

        Route::get('vessels/create', [
            'as' => 'manifest.vessels.create',
            'uses' => 'VesselsController@create',
        ]);

        Route::post('vessels/create', [
            'as' => 'manifest.vessels.create',
            'uses' => 'VesselsController@store',
        ]);

        Route::get('schedule/{id}/edit', [
            'as' => 'manifest.schedule.edit',
            'uses' => 'VesselScheduleController@edit',
        ]);

        Route::post('schedule/{id}/edit', [
            'as' => 'manifest.schedule.edit',
            'uses' => 'VesselScheduleController@update',
        ]);

        Route::get('schedule/{id}/import', [
            'as' => 'manifest.schedule.import',
            'uses' => 'VesselScheduleController@showImport',
        ]);

        Route::get('schedule/{id}/export', [
            'as' => 'manifest.schedule.export',
            'uses' => 'VesselScheduleController@showExport',
        ]);

        Route::get('schedule/{id}/import/containers/create', [
            'as' => 'manifest.schedule.import.containers.create',
            'uses' => 'VesselScheduleController@createImportContainer',
        ]);

        Route::post('schedule/{id}/import/containers/create', [
            'as' => 'manifest.schedule.import.containers.create',
            'uses' => 'VesselScheduleController@storeImportContainer',
        ]);

        Route::post('schedule/{id}/import/containers/delete', [
            'as' => 'manifest.schedule.import.containers.delete',
            'uses' => 'VesselScheduleController@destroyImportContainer',
        ]);

        Route::get('schedule/{id}/import/cargoes/create', [
            'as' => 'manifest.schedule.import.cargoes.create',
            'uses' => 'VesselScheduleController@createImportCargo',
        ]);

        Route::post('schedule/{id}/import/cargoes/create', [
            'as' => 'manifest.schedule.import.cargoes.create',
            'uses' => 'VesselScheduleController@storeImportCargo',
        ]);

        Route::post('schedule/{id}/import/cargoes/{cargo_id}/containers/create', [
            'as' => 'manifest.schedule.import.cargoes.containers.create',
            'uses' => 'VesselScheduleController@addContainerToCargo',
        ]);

        Route::post('schedule/{id}/import/cargoes/{cargo_id}/item/create', [
            'as' => 'manifest.schedule.import.cargoes.item.create',
            'uses' => 'VesselScheduleController@addItemToCargo',
        ]);

        Route::post('schedule/{id}/export/cargoes/{cargo_id}/item/create', [
            'as' => 'manifest.schedule.export.cargoes.item.create',
            'uses' => 'VesselScheduleController@addItemToCargoExport',
        ]);

        Route::get('schedule/{id}/import/cargoes/{cargo_id}/show', [
            'as' => 'manifest.schedule.import.cargoes.show',
            'uses' => 'VesselScheduleController@showImportCargo',
        ]);

        Route::get('schedule/{id}/import/cargoes/{cargo_id}/generate', [
            'as' => 'manifest.schedule.import.cargoes.generate',
            'uses' => 'VesselScheduleController@generateDLImportCargo',
        ]);

        Route::get('schedule/{id}/export/cargoes/{cargo_id}/generate', [
            'as' => 'manifest.schedule.export.cargoes.generate',
            'uses' => 'VesselScheduleController@generateDLExportCargo',
        ]);

        Route::get('schedule/{id}/export/cargoes/{cargo_id}/show', [
            'as' => 'manifest.schedule.export.cargoes.show',
            'uses' => 'VesselScheduleController@showExportCargo',
        ]);

        Route::post('schedule/{id}/import/cargoes/{cargo_id}/issue', [
            'as' => 'manifest.schedule.import.cargoes.issue',
            'uses' => 'VesselScheduleController@issueImportCargo',
        ]);

        Route::post('schedule/{id}/export/cargoes/{cargo_id}/issue', [
            'as' => 'manifest.schedule.export.cargoes.issue',
            'uses' => 'VesselScheduleController@issueExportCargo',
        ]);

        Route::post('schedule/{id}/import/cargoes/{cargo_id}/detach', [
            'as' => 'manifest.schedule.import.cargoes.detach',
            'uses' => 'VesselScheduleController@detachImportCargo',
        ]);

        Route::get('schedule/{id}/import/cargoes/{cargo_id}/edit', [
            'as' => 'manifest.schedule.import.cargoes.edit',
            'uses' => 'VesselScheduleController@editImportCargo',
        ]);

        Route::get('schedule/{id}/export/cargoes/{cargo_id}/edit', [
            'as' => 'manifest.schedule.export.cargoes.edit',
            'uses' => 'VesselScheduleController@editExportCargo',
        ]);

        Route::get('schedule/{id}/import/cargoes/{cargo_id}/{cargo_item_id}/edit', [
            'as' => 'manifest.schedule.import.cargoes.item.edit',
            'uses' => 'VesselScheduleController@editImportCargoItem',
        ]);

        Route::get('schedule/{id}/export/cargoes/{cargo_id}/{cargo_item_id}/edit', [
            'as' => 'manifest.schedule.export.cargoes.item.edit',
            'uses' => 'VesselScheduleController@editExportCargoItem',
        ]);

        Route::post('schedule/{id}/import/cargoes/{cargo_id}/item/update', [
            'as' => 'manifest.schedule.import.cargoes.item.update',
            'uses' => 'VesselScheduleController@updateImportCargoItem',
        ]);

        Route::post('schedule/{id}/export/cargoes/{cargo_id}/{cargo_item_id}/update', [
            'as' => 'manifest.schedule.export.cargoes.item.update',
            'uses' => 'VesselScheduleController@updateExportCargoItem',
        ]);

        Route::post('schedule/{id}/import/cargoes/{cargo_id}/update', [
            'as' => 'manifest.schedule.import.cargoes.update',
            'uses' => 'VesselScheduleController@updateImportCargo',
        ]);

        Route::get('schedule/{id}/export/cargoes/{cargo_id}/edit', [
            'as' => 'manifest.schedule.export.cargoes.edit',
            'uses' => 'VesselScheduleController@editExportCargo',
        ]);

        Route::post('schedule/{id}/export/cargoes/{cargo_id}/update', [
            'as' => 'manifest.schedule.export.cargoes.update',
            'uses' => 'VesselScheduleController@updateExportCargo',
        ]);
    });
/*
|--------------------------------------------------------------------------
| Admin | Receiving Advice
|--------------------------------------------------------------------------
 */

    Route::group(['prefix' => 'receiving'], function () {

        Route::any('/', [
            'as' => 'receiving',
            'uses' => 'ReceivingController@index',
        ]);

        Route::get('{id}', [
            'as' => 'receiving.show',
            'uses' => 'ReceivingController@show',
        ]);

        Route::post('{id}', [
            'as' => 'receiving.container.delete',
            'uses' => 'ReceivingController@deleteContainer',
        ]);

        Route::get('{id}/cargo/{cargo_id}', [
            'as' => 'receiving.cargo.show',
            'uses' => 'ReceivingController@showCargo',
        ]);

        Route::post('{id}/cargo/{cargo_id}/issue', [
            'as' => 'receiving.cargo.issue',
            'uses' => 'ReceivingController@issueDL',
        ]);

        Route::post('{id}/cargo/{cargo_id}/item/create', [
            'as' => 'receiving.cargo.item.create',
            'uses' => 'ReceivingController@cargoItemCreate',
        ]);

        Route::get('{id}/cargo/{cargo_id}/item/{item_id}/edit', [
            'as' => 'receiving.cargo.item.edit',
            'uses' => 'ReceivingController@cargoItemEdit',
        ]);

        Route::post('{id}/cargo/{cargo_id}/item/{item_id}/update', [
            'as' => 'receiving.cargo.item.update',
            'uses' => 'ReceivingController@cargoItemUpdate',
        ]);

        Route::post('{id}/cargo/{cargo_id}', [
            'as' => 'receiving.cargo.container.unlink',
            'uses' => 'ReceivingController@unlinkContainer',
        ]);

        Route::get('{id}/cargo/{cargo_id}/edit', [
            'as' => 'receiving.cargo.edit',
            'uses' => 'ReceivingController@editCargo',
        ]);

        Route::post('{id}/cargo/{cargo_id}/edit', [
            'as' => 'receiving.cargo.edit',
            'uses' => 'ReceivingController@updateCargo',
        ]);

        Route::post('{id}/cargo/{cargo_id}/containers', [
            'as' => 'receiving.cargo.containers.create',
            'uses' => 'ReceivingController@associateContainersWithCargo',
        ]);

        Route::get('containers/create', [
            'as' => 'receiving.containers.create',
            'uses' => 'ReceivingController@createContainer',
        ]);

        Route::post('containers/create', [
            'as' => 'receiving.containers.create',
            'uses' => 'ReceivingController@storeContainer',
        ]);

        Route::get('cargoes/create', [
            'as' => 'receiving.cargoes.create',
            'uses' => 'ReceivingController@createCargo',
        ]);

        Route::post('cargoes/create', [
            'as' => 'receiving.cargoes.create',
            'uses' => 'ReceivingController@storeCargo',
        ]);

    });

/*
|--------------------------------------------------------------------------
| Admin | Movement
|--------------------------------------------------------------------------
 */
    Route::group(['prefix' => 'movement'], function () {

/*
|--------------------------------------------------------------------------
| Admin | WorkOrder
|--------------------------------------------------------------------------
 */

        Route::group(['prefix' => 'workorders'], function () {

            Route::any('/', [
                'as' => 'workorders',
                'uses' => 'WorkOrderController@index',
            ]);

            Route::get('/create', [
                'as' => 'workorders.create',
                'uses' => 'WorkOrderController@create',
            ]);

            Route::post('/create', [
                'as' => 'workorders.create',
                'uses' => 'WorkOrderController@store',
            ]);

            Route::get('/carrier_list', [
                'as' => 'workorders.carrier_list',
                'uses' => 'WorkOrderController@carrierList',
            ]);

            Route::get('/handler_list', [
                'as' => 'workorders.handler_list',
                'uses' => 'WorkOrderController@handlerList',
            ]);

            Route::get('/container_list', [
                'as' => 'workorders.container_list',
                'uses' => 'WorkOrderController@containerList',
            ]);

            Route::get('{id}', [
                'as' => 'workorders.show',
                'uses' => 'WorkOrderController@show',
            ]);

            Route::get('{id}/generate', [
                'as' => 'workorders.generate',
                'uses' => 'WorkOrderController@generate_workorder',
            ]);

            Route::get('{id}/generate/handling', [
                'as' => 'workorders.generate.handling',
                'uses' => 'WorkOrderController@generate_handling',
            ]);

            Route::get('{id}/recalculate', [
                'as' => 'workorders.recalculate',
                'uses' => 'WorkOrderController@recalculate',
            ]);

            Route::post('{id}', [
                'as' => 'workorders.show',
                'uses' => 'WorkOrderController@cancelContainer',
            ]);

            Route::get('/unstuffing/create', [
                'as' => 'workorders.unstuffing',
                'uses' => 'WorkOrderController@createUnstuffing',
            ]);

            Route::post('/unstuffing/create', [
                'as' => 'workorders.unstuffing',
                'uses' => 'WorkOrderController@storeUnstuffing',
            ]);

            Route::get('/stuffing/create', [
                'as' => 'workorders.stuffing',
                'uses' => 'WorkOrderController@createStuffing',
            ]);

            Route::post('/stuffing/create', [
                'as' => 'workorders.stuffing',
                'uses' => 'WorkOrderController@storeStuffing',
            ]);

            Route::post('{workorder_id}/add', [
                'as' => 'workorders.containers.add',
                'uses' => 'WorkOrderController@addContainers',
            ]);            
        });

/*
|--------------------------------------------------------------------------
| Admin | Containers
|--------------------------------------------------------------------------
 */

        Route::group(['prefix' => 'containers'], function () {

            Route::get('/', [
                'as' => 'containers',
                'uses' => 'ContainerController@index',
            ]);

            Route::get('/report', [
                'as' => 'containers.report',
                'uses' => 'ContainerController@report',
            ]);

            Route::get('/{container_id}', [
                'as' => 'containers.show',
                'uses' => 'ContainerController@show',
            ]);

        });

/*
|--------------------------------------------------------------------------
| Admin | Container Confirmation
|--------------------------------------------------------------------------
 */

        Route::group(['prefix' => 'confirmation'], function () {

            Route::get('/', [
                'as' => 'confirmation',
                'uses' => 'ContainerConfirmationController@index',
            ]);

            Route::post('/', [
                'as' => 'confirmation',
                'uses' => 'ContainerConfirmationController@update',
            ]);

        });

    });

/*
|--------------------------------------------------------------------------
| Admin | Cargo
|--------------------------------------------------------------------------
 */
    Route::group(['prefix' => 'cargo'], function () {

        Route::get('/list', [
            'as' => 'cargo',
            'uses' => 'CargoController@index',
        ]);
/*
|--------------------------------------------------------------------------
| Admin | Cargo Confirmation
|--------------------------------------------------------------------------
 */

        Route::group(['prefix' => 'confirmation'], function () {

            Route::get('import', [
                'as' => 'cargo.confirmation.import',
                'uses' => 'CargoConfirmationController@indexImport',
            ]);

            Route::post('import', [
                'as' => 'cargo.confirmation.import',
                'uses' => 'CargoConfirmationController@updateImport',
            ]);

            Route::get('export', [
                'as' => 'cargo.confirmation.export',
                'uses' => 'CargoConfirmationController@indexExport',
            ]);

            Route::post('export', [
                'as' => 'cargo.confirmation.export',
                'uses' => 'CargoConfirmationController@updateExport',
            ]);

        });

    });

/*
|--------------------------------------------------------------------------
| Admin | Reports
|--------------------------------------------------------------------------
 */
    Route::get('reports', [
        'as' => 'reports',
        'uses' => 'ReportsController@index',
    ]);

/*
|--------------------------------------------------------------------------
| Admin | Customs Tariff
|--------------------------------------------------------------------------
 */
    Route::get('tariff', [
        'as' => 'tariff',
        'uses' => 'TariffController@index',
    ]);

    Route::get('tariff/find', [
        'as' => 'tariff.find',
        'uses' => 'TariffController@find',
    ]);
    
/*
|--------------------------------------------------------------------------
| Admin | Port Users
|--------------------------------------------------------------------------
 */
    Route::get('portusers', [
        'as' => 'portusers',
        'uses' => 'PortUsersController@index',
    ]);

    Route::get('portusers/create', [
        'as' => 'portusers.create',
        'uses' => 'PortUsersController@create',
    ]);

    Route::post('portusers/create', [
        'as' => 'portusers.create',
        'uses' => 'PortUsersController@store',
    ]);

/*
|--------------------------------------------------------------------------
| Admin | Statistics
|--------------------------------------------------------------------------
 */
    Route::get('statistics/dashboard', [
        'as' => 'statistics.dashboard',
        'uses' => 'StatisticsController@dashboard',
    ]);

/*
|--------------------------------------------------------------------------
| Admin | Settings
|--------------------------------------------------------------------------
 */
    Route::get('settings/fees', [
        'as' => 'settings.fees',
        'uses' => 'SettingsController@feesIndex',
    ]);

    Route::post('settings/fees', [
        'as' => 'settings.fees',
        'uses' => 'SettingsController@feesStore',
    ]);
});

/*
|--------------------------------------------------------------------------
| Mobile
|--------------------------------------------------------------------------
 */

Route::group(['prefix' => 'mobile', 'before' => 'auth.mobile'], function () {

    Route::get('/', [
        'as' => 'mobile',
        'uses' => 'MobileController@overview',
    ]);

    Route::post('/find', [
        'as' => 'mobile.find',
        'uses' => 'MobileController@getActiveByContainerNo',
    ]);

    Route::post('/confirmation', [
        'as' => 'mobile.confirm',
        'uses' => 'MobileController@confirmation',
    ]);

    Route::post('/pwdcheck', [
        'as' => 'mobile.pwdcheck',
        'uses' => 'MobileController@pwdCheck',
    ]);

    Route::get('/refresh', [
        'as' => 'mobile.refresh',
        'uses' => 'MobileController@refresh',
    ]);

});
