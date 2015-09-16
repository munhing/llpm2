<?php

use LLPM\Forms\UserForm;
use LLPM\Forms\RoleForm;
use LLPM\Repositories\UserRepository;
use LLPM\Repositories\RoleRepository;
use LLPM\Repositories\PermissionRepository;
use LLPM\Users\RegisterUserCommand;
use LLPM\Users\RegisterRoleCommand;

class UsersController extends \BaseController {

	private $userForm;
	private $roleForm;	
	private $userRepository;
	private $roleRepository;
	private $permissionRepository;

	function __construct(
		UserForm $userForm, 
		RoleForm $roleForm, 
		UserRepository $userRepository, 
		RoleRepository $roleRepository, 
		PermissionRepository $permissionRepository
	)
	{
		$this->userForm = $userForm;
		$this->roleForm = $roleForm;		
		$this->userRepository = $userRepository;
		$this->roleRepository = $roleRepository;
		$this->permissionRepository = $permissionRepository;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = $this->userRepository->getAll();
		// dd($users->toArray());
		return View::make('users/index', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//dd('register');
		return View::make('users/create');
	}


	/**
	 * Secret Registration form
	 *
	 * @return Response
	 */
	public function secretRegister()
	{
		//dd('register');
		return View::make('users/secret_register');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->userForm->validate(Input::all());

		$user = $this->execute(RegisterUserCommand::class);

		//Auth::login($user);

		Flash::success("User $user->username has been registered!");

		return Redirect::home();
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function indexRole()
	{
		$roles = $this->roleRepository->getAll();
		return View::make('users/index_role', compact('roles'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function createRole()
	{
		//dd('register');
		return View::make('users/create_role');
	}


	public function storeRole()
	{
		$this->roleForm->validate(Input::all());

		$role = $this->execute(RegisterRoleCommand::class);

		Flash::success("Role $role->role has been registered!");

		return Redirect::route('roles');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function indexPermission()
	{
		$permissions = $this->permissionRepository->getAll();
		return View::make('users/index_permission', compact('permissions'));
	}

	public function getUsersByRole()
	{
		$role = Input::get('cp');
		$users = $this->roleRepository->getByRole($role)->users;

		return $users->toJson();
	}
}
