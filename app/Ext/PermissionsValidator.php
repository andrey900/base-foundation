<?php

namespace App\Ext;

use App\Ext\Kernel;
use App\Models\Groups;
use App\Models\Permissions;
use Facade\Collection;
use Zend\Permissions\Acl\Acl;


class PermissionsValidator
{
	protected $acl;
	protected $user;
	protected $groups;
	protected $permissionsForGroups;

	public function __construct()
	{
		$this->user = Kernel::getInstance('user');
		$this->groups = $this->user->groups;
		$this->init();
	}

	protected function init()
	{
/*		$permissionsForGroups = new Collection;
		foreach ($this->groups as $group) {
			$permissionsForGroups[$group->code] = new Collection;
			foreach($group->permissions as $item){
				$permissionsForGroups[$group->code][$item->module] = $item->getPermissionsByName();
			};
		};
		p($permissionsForGroups);*/

		$this->initAcl();
	}

	protected function initAcl()
	{
		$this->acl = new Acl();
		$settings = Kernel::getInstance('settings')['settings'];

		$permissions = Permissions::all()->keyBy('module');

		$groups = Groups::allActive();

		foreach ($groups as $group) {
			$this->acl->addRole($group->code);
			if( $group->id == 1 )
				$this->acl->allow($group->code);
			if( $group->code == 'guest' )
				$this->acl->deny('guest', null);
		}

		foreach ($settings['permissions']['admin_resources'] as $module) {
			$this->acl->addResource((string)$module);
			if( !$permissions[$module] )
				continue;

			$group = $permissions[$module]->group;

			if( $group->active )
				$this->acl->allow($group->code, $module, $permissions[$module]->getPermissionsByName());
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
}