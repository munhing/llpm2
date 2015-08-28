<?php namespace LLPM\Repositories;

use Role;

class RoleRepository {

	public function save(Role $role)
	{
		return $role->save();
	}

	public function getAll()
	{
		return Role::orderBy('role')->get();
	}
}