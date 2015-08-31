<?php

class ContainerWorkorderConfirmation extends \Eloquent {

	protected $fillable = ['container_id', 'container_no', 'workorder_id', 'workorder_no', 'container_workorder_id', 'confirmed_by', 'role', 'confirmed_at'];

	protected $table = "container_workorder_confirmation";

	protected $dates = array('confirmed_at');

	public function container()
	{
		return $this->belongsTo('Container', 'container_id');
	}	

	public function workorder()
	{
		return $this->belongsTo('WorkOrder', 'workorder_id');
	}

	public function user()
	{
		return $this->belongsTo('User', 'confirmed_by');
	}

	public function containerConfirmation()
	{
		return $this->belongsTo('ContainerConfirmation', 'container_workorder_id');
	}	
}