<?php

namespace App\Models;

use App\Events\UsersEvent;

/**
* 
*/
class Users extends BaseModel
{
	protected $table = 'users';

	protected $fillable = ['login', 'password', 'email', 'first_name', 'last_name', 'active', 'verified', 'password1', 'password2'];

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
			\Dispatcher::dispatch(UsersEvent::BEFORE_REGISTER, $event);
		}

		parent::save();

		if( $registerUser ){
			$event = new UsersEvent($this);
			\Dispatcher::dispatch(UsersEvent::AFTER_REGISTER, $event);
		}

		$event = new UsersEvent($this);
		\Dispatcher::dispatch(UsersEvent::AFTER_SAVE, $event);
	}
}