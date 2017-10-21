<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\BaseModel;
use Illuminate\Support\Collection;
use App\Models\Users as UsersEntity;

class Auth extends BaseController
{
	protected function indexAction()
	{
		p(UsersEntity::find(1));
	}

	protected function loginAction()
	{
		$data = $this->request->getParsedBody();
		$user = UsersEntity::where('username', $data['login'])->where('password', $data['password'])->get()->first();

		if( $user ){
			$_SESSION['auth'] = new Collection([
				'user.id' => $user->id,
				'user.login' => $user->username,
				'user.first_name' => $user->first_name,
				'user.last_name' => $user->last_name,
			]);

			return $this->response->withRedirect('/admin/users');
		}
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