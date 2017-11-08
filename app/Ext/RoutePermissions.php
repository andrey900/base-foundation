<?php

namespace App\Ext;

use App\Ext\Kernel;
use App\Models\Groups;
use Facade\Collection;
use App\Models\Permissions;
use Zend\Permissions\Acl\Acl;

class RoutePermissions
{
	protected $acl;
	protected $user;
	protected $groups;
	protected $allGroups;
	protected $permissions;
	protected $groupDefault;
	protected $permissionsForGroups;

	public function __construct()
	{
		$this->groupDefault = Groups::default()->first();

		$this->user = Kernel::getInstance('user');
		if( $this->user )
			$this->groups = $this->user->groups;
		else
			$this->groups = new Collection([$this->groupDefault]);

		$this->acl = new Acl();

		$this->permissions = Permissions::all();

		$this->allGroups = Groups::allActive();

		$this->init();
	}

	protected function init()
	{
		$routePermissions = $this->permissions->where('module', 'route.name');

		$defaultRole = $this->groupDefault->code;
		$this->acl->addRole($defaultRole);
		$this->acl->deny($defaultRole, null);

		foreach ($this->allGroups as $group) {
			if( $defaultRole != $group->code )
				$this->acl->addRole($group->code, $defaultRole);
			
			if( $group->id == 1 )
				$this->acl->allow($group->code, null);
		}

		$this->acl->addResource('default.default');
		$this->acl->addResource('route:default.default');

		$groups = $this->allGroups->keyBy('id');
		foreach ($routePermissions as $item) {
			$module = 'route:'.$item->route;
			if( !$this->acl->hasResource($module) )
				$this->acl->addResource($module);

			$group = $groups[$item->group_id];

			$permissionsByName = $item->getPermissionsByName();

			if( $group->active && $permissionsByName)
				$this->acl->allow($group->code, $module, $permissionsByName);
		}
	}

	public function isAllowed($module, $action)
	{
		foreach ($this->groups as $group) {
			if ($this->acl->isAllowed($group->code, $module, $action))
				return true;
		}

		return false;
	}

	public function hasModule($module)
	{
		return $this->acl->hasResource($module);
	}
}