<?php

use Laracasts\Commander\Events\EventGenerator;

class Fee extends \Eloquent {

	use EventGenerator;

	protected $table = 'fees';

	protected $fillable = ['type', 'fee', 'effective_date'];

	protected $dates = array('effective_date');

	public static function register($type, $fee, $effective_date)
	{
		$handlingFee = new static(compact('type', 'fee', 'effective_date'));

		// $portUser->raise(new PortUserWasRegistered($portUser));

		return $handlingFee;
	}

	public static function edit($id, $fee, $effective_date)
	{
		$handlingFee = static::find($id);

        $handlingFee->fee = $fee;
        $handlingFee->effective_date = $effective_date;

		// $workorder->raise(new WorkOrderWasUpdated($workorder));

		return $handlingFee;
	}		
}