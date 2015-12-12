<?php

use LLPM\Forms\UserForm;
use LLPM\Forms\RoleForm;
use LLPM\Repositories\UserRepository;
use LLPM\Repositories\RoleRepository;
use LLPM\Repositories\PermissionRepository;
use LLPM\Users\RegisterUserCommand;
use LLPM\Users\UpdateUserCommand;
use LLPM\Users\UpdateUserProfileCommand;
use LLPM\Users\UpdateUserPasswordCommand;
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
		$roles = $this->roleRepository->getAll();
		// dd($users->toArray());
		return View::make('users/index', compact('users', 'roles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//dd('register');
		$roles = $this->roleRepository->getAll();
		// dd($roles->toArray());
		return View::make('users/create', compact('roles'));
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

		Flash::success("User $user->username has been registered!");

		return Redirect::route('users');
	}

	public function update()
	{
		$input = Input::all();

		$this->userForm->validateUpdate($input);
		// dd($input);

		$user = $this->execute(UpdateUserCommand::class);

		Flash::success("User $user->username has been updated!");

		return Redirect::back();		
	}

	public function updateProfile()
	{
		$input = Input::all();

		$this->userForm->validateUpdateProfile($input);

		$user = $this->execute(UpdateUserProfileCommand::class);

		Flash::success("User $user->username has been updated!");

		return Redirect::back();		
	}

	public function updatePassword()
	{
		$input = Input::all();
		
		$this->userForm->validateUpdatePassword($input);

		$user = $this->execute(UpdateUserPasswordCommand::class);

		Flash::success("Password changed for User $user->username!");

		return Redirect::back();		
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

	public function rolePermissions($role_id)
	{
		// dd($role_id);
		$role = $this->roleRepository->getById($role_id);
		$permissions = $this->permissionRepository->getAll();
		return View::make('users/role_permission', compact('role', 'permissions'));		
	}

	public function rolePermissionsUpdate($role_id)
	{
		$input = Input::all();
		$input['role_id'] = $role_id;
		// dd($input);
		$this->roleRepository->updatePermission($input['role_id'], $input['permit_id']);

		Flash::success("Access updated!");

		return Redirect::back();		
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

		if($role == 'MG') {
			$role = 'PB';
		}

		$users = $this->roleRepository->getByRole($role)->users;

		return $users->toJson();
	}

	public function checkAuth()
	{
		$input = Input::all();

		if(Hash::check($input['auth_password'], Auth::user()->password))
		{
			// return true
			return 1;
		}

		// return false
		return 0;
	}	

	public function profile()
	{
		// dd('My Profile');
		return View::make('users/profile');
	}		
}
