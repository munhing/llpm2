<?php

use Illuminate\Database\Eloquent\Relations\Pivot;

class ContainerWorkorderPivot extends Pivot {

	protected $dates = ['confirmed_at'];	
}