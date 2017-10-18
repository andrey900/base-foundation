<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\Users as UsersEntity;

class Users extends BaseController
{
	protected function indexAction()
	{
		$this->viewCollection['users'] = UsersEntity::all();
	}

	protected function showAction()
	{
		$this->viewCollection['user'] = UsersEntity::find($this->request->getAttribute('id'));
	}
}