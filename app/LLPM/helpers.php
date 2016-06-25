<?php

function convertToMySQLDate($date)
{
	//return date("Y-m-d", strtotime($date));
	$date = DateTime::createFromFormat('d/m/Y', $date);
	
	return $date->format('Y-m-d');

}

function convertMonthToMySQLDate($date)
{
	//return date("Y-m-d", strtotime($date));
	// $date = DateTime::createFromFormat('m/Y', $date);
	
	//dd($date->format('Y-m'));
	$arr_date = explode("/", $date);

	// return $date->format('Y-m');
	return $arr_date[1] . "-" . $arr_date[0];
}

function listContainersInString($containers)
{
	$list = '';

	if($containers) {

		foreach ($containers as $container) {
			$list .= $container->container_no . " ";
		}

	}

	return $list;
}

function checkDl($dlNo, $schedule_id, $importCargo_id)
{
	if($dlNo > 0) {
		return '';
	}

	$link = link_to_route('manifest.schedule.import.cargoes.issue', 'Issue DL', [$schedule_id, $importCargo_id]);

	return $link;
}

function getWorkOrderRI($workorders)
{
	foreach($workorders as $workorder) {
		if($workorder->movement == 'RI'){
			return $workorder;
		}
	}
	return false;
}

function importCargoStatusTranslator($status)
{

	switch ($status) {
	    case "1":
	        echo "<span class='badge badge-danger badge-roundless'>Onboard</span>";
	        break;
	    case "2":
	        echo "<span class='badge badge-warning badge-roundless'>Received</span>";
	        break;
	    case "3":
	        echo "<span class='badge badge-info badge-roundless'>DL Issued</span>";
	        break;
	    case "4":
	        echo "<span class='badge badge-success badge-roundless'>Released</span>";
	        break;	        
	    default:
	        break;
	}

}

function cargoStatusTranslator($status, $import_vessel_schedule_id)
{

	if ($import_vessel_schedule_id != 0) {

		switch ($status) {
		    case "1":
		        echo "<span class='badge badge-danger badge-roundless'>Onboard</span>";
		        break;
		    case "2":
		        echo "<span class='badge badge-warning badge-roundless'>Received</span>";
		        break;
		    case "3":
		        echo "<span class='badge badge-info badge-roundless'>DL Issued</span>";
		        break;
		    case "4":
		        echo "<span class='badge badge-success badge-roundless'>Released</span>";
		        break;	        
		    default:
		        break;
		}

	}

	if ($import_vessel_schedule_id == 0) {

		switch ($status) {
		    case "1":
		        echo "<span class='badge badge-danger badge-roundless'>With Agent</span>";
		        break;
		    case "2":
		        echo "<span class='badge badge-warning badge-roundless'>DL Issued</span>";
		        break;
		    case "3":
		        echo "<span class='badge badge-info badge-roundless'>In the Port</span>";
		        break;
		    case "4":
		        echo "<span class='badge badge-success badge-roundless'>Released</span>";
		        break;	        
		    default:
		        break;
		}
			
	}
}

function cargoMovementTranslator($import_vessel_schedule_id)
{
	if ($import_vessel_schedule_id == 0) {
		return "<span class='badge badge-warning badge-roundless'>Export</span>";
	}

	return "<span class='badge badge-success badge-roundless'>Import</span>";
}

function exportCargoStatusTranslator($status)
{

	switch ($status) {
	    case "1":
	        echo "<span class='badge badge-danger badge-roundless'>With Agent</span>";
	        break;
	    case "2":
	        echo "<span class='badge badge-info badge-roundless'>DL Issued</span>";
	        break;
	    case "3":
	        echo "<span class='badge badge-warning badge-roundless'>In the Port</span>";
	        break;
	    case "4":
	        echo "<span class='badge badge-success badge-roundless'>Released</span>";
	        break;	        
	    default:
	        break;
	}

}

if ( ! function_exists('elixir'))
{
	  /**
	    * Get the path to a versioned Elixir file.
    	*
    	* @param  string  $file
    	* @return string
  	*/
  	function elixir($file)
  	{
    		static $manifest = null;

    		if (is_null($manifest))
    		{
      			$manifest = json_decode(file_get_contents(public_path().'/build/rev-manifest.json'), true);
    		}

    		if (isset($manifest[$file]))
    		{
      			return '/build/'.$manifest[$file];
    		}

    		throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
  	}
}


