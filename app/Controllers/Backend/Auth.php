<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\BaseModel;
use App\Models\Users as UsersEntity;

class Auth extends BaseController
{
	protected function indexAction()
	{

	}

	protected function loginAction()
	{

	}

	protected function logoutAction()
	{

	}

	protected function createAction()
	{
		$this->viewCollection['user'] = new UsersEntity;
		return $this->render('pages/users/edit.html');
	}

	protected function storeAction()
	{
		$id = UsersEntity::create($this->request->getParsedBody());
		if( $id )
			return $this->response->withRedirect('/personal');
		else
			return $this->response->withRedirect('/register');
	}
}