<?php

namespace App\Controllers\Backend;

use App\Ext\Kernel;
use App\Ext\PermissionsForUser;
use App\Models\BaseModel;
use App\Models\Groups as GroupsEntity;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;

class Permissions extends BaseAdminController
{
	protected function indexAction()
	{
		$r = Kernel::getInstance('container')->get('router')->getRoutes();

		// p($this->session['auth']['user.groups']);

/*		$p = Kernel::getInstance('settings')['settings']['permissions']['privileges'];
		p($p);*/
/*
		$r = $p['read'] + $p['write'] + $p['create'];

		$perms = [];
		foreach ($p as $role => $value) {
			if( $r & $value )
				$perms[] = $role;
		}
		p($perms);

		$s = new PermissionsForUser;
		p($s->isAllowed('users', 'write'));
		// p($s->getPermissionForResource('s'));
		
/*		$acl = new Acl();
		$acl->addResource('blog');
		$acl->addResource('users');
		$acl->addRole('guest');
		$editor = new Role('editor');
		$acl->addRole($editor, 'guest');
		$acl->allow('guest', null, 'read');
		$acl->allow('editor', 'blog', ['read', 'write']);


		p($acl->isAllowed('guest', 'blog', 'read'));
		p($acl->isAllowed('guest', 'blog', 'write'));
		p($acl->isAllowed('guest', 'users', 'read'));
		p($acl->isAllowed('guest', 'users', 'write'));
		p($acl->isAllowed('editor', 'blog', 'read'));
		p($acl->isAllowed('editor', 'blog', 'write'));*/

		// $this->viewCollection['permissions'] = $r;
	}

	protected function showAction()
	{
		$this->viewCollection['group'] = GroupsEntity::find($this->request->getAttribute('id'));
		$this->viewCollection['users'] = $this->viewCollection['group']->users;
	}

	protected function editAction()
	{
		$this->viewCollection['group'] = GroupsEntity::find($this->request->getAttribute('id'));
        if( $formFields = $this->flash->getMessage('jsonFormData') ){
            $formFields = (array)json_decode($formFields[0]);
            $this->viewCollection['group']->fill($formFields);
        }
	}

	protected function createAction()
	{
		$this->viewCollection['group'] = new GroupsEntity;
        
        if( $formFields = $this->flash->getMessage('jsonFormData') ){
            $formFields = (array)json_decode($formFields[0]);
            $this->viewCollection['group'] = new GroupsEntity($formFields);
        }
		
        return $this->render('pages/groups/edit.html');
	}

	protected function storeAction()
	{
        $formData = $this->request->getParsedBody();
		$user = new GroupsEntity;
		$user = $user->create($formData);
		if( !$user->isSuccess() ){
			foreach ($user->getErrors() as $error) {
				$this->flash->addMessage('errors', $error);
			}
            
            $this->flash->addMessage('jsonFormData', json_encode($formData));
            
			return $this->response->withRedirect('/admin/groups/create');
		} else {
			$this->flash->addMessage('success', 'group is created');
			return $this->response->withRedirect('/admin/groups/'.$user->id);
		}
	}

	protected function updateAction()
	{
		$data = $this->request->getParsedBody();
		$user = GroupsEntity::find($this->request->getAttribute('id'));
		$user->update($data);
		if( !$user->isSuccess() ){
			foreach ($user->getErrors() as $error) {
				$this->flash->addMessage('errors', $error);
			}
            
            $this->flash->addMessage('jsonFormData', json_encode($data));
            
			return $this->response->withRedirect('/admin/groups/'.$user->id.'/edit');
		} else {
			$this->flash->addMessage('success', 'group is updated');
			return $this->response->withRedirect('/admin/groups/'.$user->id);
		}
	}

	protected function destroyAction()
	{
		$user = GroupsEntity::find($this->request->getAttribute('id'));
		$user->delete();
		return $this->response->withRedirect('/admin/groups');
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