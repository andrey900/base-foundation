<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\BaseModel;
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

	protected function editAction()
	{
		$this->viewCollection['user'] = UsersEntity::find($this->request->getAttribute('id'));
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
			return $this->response->withRedirect('/admin/users');
		else
			return $this->response->withRedirect('/admin/users/create');
	}

	protected function updateAction()
	{
		$data = $this->request->getParsedBody();
		$user = UsersEntity::find($this->request->getAttribute('id'));
		$user->update($data);
		return $this->response->withRedirect('/admin/users/'.$user->id);
	}

	protected function destroyAction()
	{
		$user = UsersEntity::find($this->request->getAttribute('id'));
		$user->delete();
		return $this->response->withRedirect('/admin/users');
	}

	protected function updelAction()
	{
		$data = $this->request->getParsedBody();
		$method = strtolower($data['_method']);
		if( $method == 'put' ){
			return $this->updateAction();
		} elseif( $method == 'delete' ){
			return $this->destroyAction();
		}
	}
}