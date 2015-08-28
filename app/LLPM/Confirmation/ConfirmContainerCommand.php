<?php namespace LLPM\Confirmation;

class ConfirmContainerCommand {

	public $a_confirmation;
	public $a_carrier;
	public $a_lifter;

    /**
     */
    public function __construct($a_confirmation, $a_carrier, $a_lifter)
    {
		$this->a_confirmation = $a_confirmation;
		$this->a_carrier = $a_carrier;
		$this->a_lifter = $a_lifter;
    }

}