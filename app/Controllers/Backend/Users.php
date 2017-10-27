<?php

namespace App\Controllers\Backend;

use App\Models\BaseModel;
use App\Models\Users as UsersEntity;

class Users extends BaseAdminController
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
		$user = new UsersEntity;
		$user = $user->create($this->request->getParsedBody());
		if( !$user->isSuccess() ){
			foreach ($user->getErrors() as $error) {
				$this->flash->addMessage('errors', $error);
			}
			return $this->response->withRedirect('/admin/users/create');
		} else {
			$this->flash->addMessage('success', 'users is created');
			return $this->response->withRedirect('/admin/users/'.$user->id);
		}
		// if( $id )
			// return $this->response->withRedirect('/admin/users');
		// else
			// return $this->response->withRedirect('/admin/users/create');
	}

	protected function updateAction()
	{
		$data = $this->request->getParsedBody();
		$user = UsersEntity::find($this->request->getAttribute('id'));
		$user->update($data);
		if( !$user->isSuccess() ){
			foreach ($user->getErrors() as $error) {
				$this->flash->addMessage('errors', $error);
			}
			return $this->response->withRedirect('/admin/users/'.$user->id.'/edit');
		} else {
			$this->flash->addMessage('success', 'users is updated');
			return $this->response->withRedirect('/admin/users/'.$user->id);
		}
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