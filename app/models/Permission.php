<?php

class Permission extends \Eloquent {

	protected $fillable = ['name'];

	public function roles()
	{
		return $this->belongsToMany('Role');
	}	
}