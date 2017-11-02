<?php

namespace App\Controllers\Backend;

use App\Models\BaseModel;
use App\Models\Users as UsersEntity;
use App\Models\Groups as GroupsEntity;

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
		$this->viewCollection['user_groups'] = $this->viewCollection['user']->groups->keyBy('id');
		
		$this->viewCollection['groups'] = GroupsEntity::allActive();

        if( $formFields = $this->flash->getMessage('jsonFormData') ){
            $formFields = (array)json_decode($formFields[0]);
            $this->viewCollection['user']->fill($formFields);
        }
	}

	protected function createAction()
	{
		$this->viewCollection['user'] = new UsersEntity;
		$this->viewCollection['groups'] = GroupsEntity::allActive();
        
        if( $formFields = $this->flash->getMessage('jsonFormData') ){
            $formFields = (array)json_decode($formFields[0]);
            $this->viewCollection['user'] = new UsersEntity($formFields);
        }
		
        return $this->render('pages/users/edit.html');
	}

	protected function storeAction()
	{
        $formData = $this->request->getParsedBody();
		$user = new UsersEntity;
		$user = $user->create($formData);
		if( !$user->isSuccess() ){
			foreach ($user->getErrors() as $error) {
				$this->flash->addMessage('errors', $error);
			}
            
            $this->flash->addMessage('jsonFormData', json_encode($formData));
            
			return $this->response->withRedirect('/admin/users/create');
		} else {
			$user->groups()->sync($formData['user_groups']);
			$this->flash->addMessage('success', 'users is created');
			return $this->response->withRedirect('/admin/users/'.$user->id);
		}
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
            
            $this->flash->addMessage('jsonFormData', json_encode($data));
            
			return $this->response->withRedirect('/admin/users/'.$user->id.'/edit');
		} else {
			$user->groups()->sync($data['user_groups']);
			$this->flash->addMessage('success', 'users is updated');
			return $this->response->withRedirect('/admin/users/'.$user->id);
		}
	}

	protected function destroyAction()
	{
		$user = UsersEntity::find($this->request->getAttribute('id'));
		$user->groups()->detach(GroupsEntity::all()->keyBy('id')->keys());
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