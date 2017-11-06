<?php

namespace App\Models;

use App\Ext\Kernel;
use App\Events\GroupsEvent;
use Illuminate\Support\Str;

/**
* 
*/
class Groups extends BaseModel
{
	public $timestamps = false;

	protected $table = 'groups';

	protected $rules = [
		'code' => [
	        'required',
	        'min_length(3)'
	    ],
		'name' => [
	        'required'
	    ]
	];

	protected $ruleMessages = [
		'code_exists' => 'Code group exist, please input other code',
		'default_disable' => 'Default group not disable active flag',
	];

	protected $fillable = ['code', 'name', 'description', 'active', 'default'];

	protected function extRules()
	{
		$this->rules['code']['code_exists('.$this->code.','.$this->id.')'] = function($input, $code, $id = 0){
				if( !$code )
					return true;

				$groups = \App\Models\Groups::where('code', Str::lower($code));
	            if( $id )
	            	$groups->where('id', '!=', $id);

	            if ($groups->count() > 0)
	                return false;

	            return true;
			};
		$this->rules['code']['default_disable('.$this->default.','.$this->active.')'] = function($input, $default, $active){
				return !(!$active && $default);
			};
	}

	public function save(array $options = [])
	{
		$this->code = Str::lower($this->code);

		$event = new GroupsEvent($this);
		Kernel::getInstance('container')->get('dispatcher')->dispatch(GroupsEvent::BEFORE_SAVE, $event);

		parent::save();

		$event = new GroupsEvent($this);
		Kernel::getInstance('container')->get('dispatcher')->dispatch(GroupsEvent::AFTER_SAVE, $event);

		$this->fixOnlyOneDefault();
	}

	protected function fixOnlyOneDefault()
	{
		// Brutal hack!!! from deactivate default value
		if( !$this->default ){
			$groups = static::where('default', 1)->get();
			if( $groups->isEmpty() ){
				$this->default = 1;
				$this->save();
			}
		}

		// Brutal hack!!! from deactivate other default group
		if( $this->default ){
			$groups = static::where('default', 1)->where('id', '!=', $this->id)->get();
			if( $groups->isNotEmpty() ){
				$groups->each(function($group){
					$group->default = false;
					$group->save();
				});
			}
		}
	}

	public static function allActive()
	{
		return static::where('active', 1)->get();
	}

	public function users()
    {
    	return $this->belongsToMany('App\Models\Users', 'group_user', 'group_id', 'user_id');
    }

    public function permissions()
    {
    	return $this->hasMany('App\Models\Permissions', 'group_id');
    }

    public function delete()
    {
    	Kernel::getInstance('container')->get('db')->table('group_user')->where('group_id', $this->id)->delete();
    	
    	return parent::delete();
    }
}