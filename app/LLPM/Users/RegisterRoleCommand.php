<?php namespace LLPM\Users;

class RegisterRoleCommand {

    /**
     * @var string
     */
    public $role;

    /**
     * @param string role
     */
    public function __construct($role)
    {
        $this->role = $role;
    }

}