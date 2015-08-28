<?php namespace LLPM\Repositories;

use Permission;

class PermissionRepository {

	public function getAll()
	{
		return Permission::orderBy('name')->get();
	}
}