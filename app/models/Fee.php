<?php

use Laracasts\Commander\Events\EventGenerator;

class Fee extends \Eloquent {

	use EventGenerator;

	protected $table = 'fees';

	protected $fillable = ['type', 'fees', 'effective_date'];

	protected $dates = array('effective_date');

}