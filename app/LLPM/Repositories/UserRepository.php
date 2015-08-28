<?php namespace LLPM\Repositories;

use User;

class UserRepository {

	public function save(User $user)
	{
		return $user->save();
	}

	public function getAll()
	{
		return User::with('roles')->orderBy('username')->get();
	}

	public function assignRole($role)
	{
		return $this->roles()->attach($role);
	}
}