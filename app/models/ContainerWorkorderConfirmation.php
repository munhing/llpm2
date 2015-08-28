<?php

class ContainerWorkorderConfirmation extends \Eloquent {

	protected $fillable = ['container_id', 'container_no', 'workorder_id', 'workorder_no', 'confirmed_by', 'role', 'confirmed_at'];

	protected $table = "container_workorder_confirmation";
}