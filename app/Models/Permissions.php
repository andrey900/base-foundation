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

    protected $rules = [];

	protected $table = 'permissions';

    protected $fillable = ['group_id', 'module', 'permissions', 'route'];

    protected $ruleMessages = [
        'permission_route_exists' => 'Permission for route exist, please input other route',
    ];

    protected function extRules()
    {
        $this->rules['route']['permission_route_exists('.$this->group_id.','.$this->module.','.$this->route.','.$this->id.')'] = function($input, $groupId, $module, $route = '', $id = ''){
                if( $module != 'route.name' )
                    return true;

                if( !$route )
                    return true;

                $perms = \App\Models\Permissions::where('group_id', $groupId)->where('module', $module)->where('route', $route);

                if( $id )
                    $perms->where('id', '!=', $id);

                if ($perms->count() > 0)
                    return false;

                return true;
            };
    }

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