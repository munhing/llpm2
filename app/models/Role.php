<?php

use Laracasts\Commander\Events\EventGenerator;
use LLPM\Users\Events\RoleWasRegistered;

class Role extends \Eloquent {

	use EventGenerator;

	protected $fillable = ['role'];

	public function users()
	{
		return $this->belongsToMany('User');
	}

	public function permissions()
	{
		return $this->belongsToMany('Permission');
	}

	public static function register($role)
	{
		$role = new static(compact('role'));

		$role->raise(new RoleWasRegistered($role));

		return $role;
	}	
}