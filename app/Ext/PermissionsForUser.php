<?php

namespace App\Ext;

use App\Models\Groups;
use Zend\Permissions\Acl\Acl;


class PermissionsForUser
{
	protected $acl;
	protected $roles;
	protected $defaultRole;
	protected $userRoles;

	public function __construct()
	{
		$this->userRoles = Kernel::getInstance('container')->get('session')['auth']['user.groups'];

		$this->roles = Groups::where('active', 1)->get()->keyBy('id');

		$this->defaultRole = $this->roles->filter(function($e){
				return (bool)$e->default;
			})->toArray();

		if( !$this->userRoles )
			$this->userRoles = $this->defaultRole->id;

		$this->acl = new Acl();
		
		$this->addResource();
		$this->addRole();
		$this->setPermissions();
	}

	public function getPermissionForResource($resource)
	{
		return Kernel::getInstance('container')->get('session')['auth'];
	}

	public function addResource()
	{
		$resources = Kernel::getInstance('settings')['settings']['permissions']['admin_resources'];

		foreach ($resources as $resource) {
			$this->acl->addResource((string)$resource);
		}
	}

	public function addRole()
	{
		foreach ($this->userRoles as $k => $role) {
			if( $this->roles->has($role) ){
				$this->acl->addRole($this->roles[$role]->code);
			} else {
				unset($this->userRoles[$k]);
			}
		}
	}

	public function setPermissions()
	{
		// $this->acl->allow($this->defaultRole->code, null, 'read');
		// test
		// $this->acl->allow('admin', null, 'write');
	}

	public function isAllowed($type, $action)
	{
		foreach ($this->userRoles as $roleId) {
			$code = $this->roles[$roleId]->code;
			if($this->acl->isAllowed($code, $type, $action))
				return true;
		};

		return false;
	}
}