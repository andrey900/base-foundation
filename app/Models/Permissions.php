<?php

namespace App\Models;

use App\Events\UsersEvent;
use App\Ext\Kernel;
use App\Models\getPermissionsByName;
use Illuminate\Support\Collection;

/**
* 
*/
class Permissions extends BaseModel
{
	public $timestamps = false;

	protected $table = 'permissions';

	public static function groupById($groupId)
	{
		return static::where('group_id', $groupId)->get();
	}

	public function group()
    {
        return $this->hasOne('App\Models\Groups', 'id', 'group_id');
    }

    public function getPermissionsByName()
    {
    	$permissions = (int)$this->permissions;

    	$p = static::getPrivileges();

    	$perms = [];
		foreach ($p as $role => $value) {
			if( $permissions & $value )
				$perms[] = $role;
		}
		
		return $perms;
    }

    public static function getPermissionsByType($type, Collection $items = null)
    {
    	$type = strtolower($type);

    	return $items->filter(function($e) use ($type){
    		return strpos($e, $type) !== false;
    	});
    }

    protected static function getPrivileges()
    {
    	return Kernel::getInstance('settings')['settings']['permissions']['privileges'];
    }
}