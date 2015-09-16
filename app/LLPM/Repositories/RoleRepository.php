<?php namespace LLPM\Repositories;

use Role;

class RoleRepository {

	public function save(Role $role)
	{
		return $role->save();
	}

	public function getByRole($role)
	{
		return Role::with('users')->where('role', $role)->first();	
	}

	public function getAll()
	{
		return Role::orderBy('role')->get();
	}
}