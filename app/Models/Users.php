<?php

namespace App\Models;

/**
* 
*/
class Users extends BaseModel
{
	protected $table = 'users';

	protected $fillable = ['username', 'login', 'password', 'email', 'first_name', 'last_name', 'active', 'verified'];
}