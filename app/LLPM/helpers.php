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
	$date = DateTime::createFromFormat('m/Y', $date);
	
	//dd($date->format('Y-m'));

	return $date->format('Y-m');

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

function exportCargoStatusTranslator($status)
{

	switch ($status) {
	    case "1":
	        echo "<span class='badge badge-danger badge-roundless'>With Agent</span>";
	        break;
	    case "2":
	        echo "<span class='badge badge-warning badge-roundless'>In the Port</span>";
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


