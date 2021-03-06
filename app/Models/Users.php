<?php

namespace App\Models;

use App\Ext\Kernel;
use App\Events\UsersEvent;

/**
* 
*/
class Users extends BaseModel
{
	protected $table = 'users';

	protected $rules = [
		'email' => [
	        'required',
	        'email'
	    ],
		'login' => [
	        'required',
	        'min_length(3)'
	    ]
	];

	protected $ruleMessages = [
		'email_exists' => 'Email exist, please input other email',
		'login_exists' => 'Login exist, please input other login'
	];

	protected $fillable = ['login', 'password', 'email', 'first_name', 'last_name', 'active', 'verified', 'password1', 'password2'];

	protected function extRules()
	{		
		$this->rules['email']['email_exists('.$this->email.','.$this->id.')'] = function($input, $email, $id = 0){
				if( !$email )
					return true;

				$users = \App\Models\Users::where('email', $email);
	            if( $id )
	            	$users->where('id', '!=', $id);

	            if ($users->count() > 0)
	                return false;

	            return true;
			};

		$this->rules['login']['login_exists('.$this->login.','.$this->id.')'] = function($input, $login, $id = 0){
				if( !$login )
					return false;

				$users = \App\Models\Users::where('login', $login);
	            if( $id )
	            	$users->where('id', '!=', $id);

	            if ($users->count() > 0)
	                return false;

	            return true;
			};
	}

	public function save(array $options = [])
	{
		if( $this->password1 && $this->password1 == $this->password2 ){
			$this->password = password_hash($this->password1, PASSWORD_BCRYPT);
		}
		unset($this->password1, $this->password2);

		$registerUser = false;
		if( !$this->id ){
			$registerUser = true;
			$event = new UsersEvent($this);
			Kernel::getInstance('container')->get('dispatcher')->dispatch(UsersEvent::BEFORE_REGISTER, $event);
		}

		parent::save();

		if( $registerUser ){
			$event = new UsersEvent($this);
			Kernel::getInstance('container')->get('dispatcher')->dispatch(UsersEvent::AFTER_REGISTER, $event);
		}

		$event = new UsersEvent($this);
		Kernel::getInstance('container')->get('dispatcher')->dispatch(UsersEvent::AFTER_SAVE, $event);
	}

	public function groups()
    {
        return $this->belongsToMany('App\Models\Groups', 'group_user', 'user_id', 'group_id');
    }

    public function isAdmin()
    {
    	return $this->groups->where('id', 1)->isNotEmpty();
    }
}