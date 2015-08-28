<?php namespace LLPM\Schedule;

class AddItemToCargoCommand {

    
	public $custom_tariff_code;
	public $description;
	public $quantity;
	public $schedule_id;
	public $cargo_id;

    public function __construct($custom_tariff_code, $description, $quantity, $schedule_id, $cargo_id)
    {
    	$this->custom_tariff_code = $custom_tariff_code;
    	$this->description = $description;
    	$this->quantity = $quantity;
    	$this->schedule_id = $schedule_id;
    	$this->cargo_id = $cargo_id;
    }

}