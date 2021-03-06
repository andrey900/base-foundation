<?php

namespace App\Controllers\Backend;

use App\Ext\Kernel;
use Facade\Collection;
use App\Models\BaseModel;
use App\Models\Groups as GroupsEntity;
use App\Models\Permissions;

class Groups extends BaseAdminController
{
	protected function indexAction()
	{
		$this->viewCollection['groups'] = GroupsEntity::all();
	}

	protected function showAction()
	{
		$this->viewCollection['group'] = GroupsEntity::find($this->request->getAttribute('id'));
		$this->viewCollection['users'] = $this->viewCollection['group']->users;
	}

	protected function editAction()
	{
		$this->viewCollection['group'] = GroupsEntity::find($this->request->getAttribute('id'));

		$this->viewCollection['privileges'] = Kernel::getInstance('settings')['settings']['permissions']['privileges'];
		$this->viewCollection['modules'] = Kernel::getInstance('settings')['settings']['permissions']['admin_resources'];

		$permissionsForGroup = Permissions::groupById($this->request->getAttribute('id'));
		$permissions = new Collection();
		$ss = $permissionsForGroup->keyBy('module');
		$ss->each(function($item, $module) use ($permissions){
			if( strpos($module, 'model') )
				$permissions[$module] = $item->getPermissionsByName();
		});

		$this->viewCollection['permissions'] = $permissions;

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
		$groupId = $this->request->getAttribute('id');

		$user = GroupsEntity::find($groupId);
		$user->update($data);
		if( !$user->isSuccess() ){
			foreach ($user->getErrors() as $error) {
				$this->flash->addMessage('errors', $error);
			}
            
            $this->flash->addMessage('jsonFormData', json_encode($data));
            
			return $this->response->withRedirect('/admin/groups/'.$user->id.'/edit');
		} else {
			$s = new Collection($data['permissions']);
			$perms = Permissions::groupById($groupId)->keyBy('module');
			$s->each(function($item, $module)use($t, $perms, $groupId){
				$r = new Collection($item);
				$sum = $r->sum();
				
				$permissions = $perms[$module];
				
				if( !$permissions ){
					$permissions = new Permissions;
					$permissions->module = $module;
					$permissions->group_id = $groupId;
				}

				if( $permissions->id && $sum == 0 ){
					$permissions->delete();
				}

				if( $sum > 0 ){
					$permissions->permissions = $sum;
					$permissions->save();
				}
			});

			$this->flash->addMessage('success', 'group is updated');
			return $this->response->withRedirect('/admin/groups/'.$user->id);
		}
	}

	protected function destroyAction()
	{
		$groupId = $this->request->getAttribute('id');
		
		$group = GroupsEntity::find($groupId);
		$group->delete();
		
		if( !$group->isSuccess() ){
			foreach ($group->getErrors() as $error) {
				$this->flash->addMessage('errors', $error);
			}
		} else {
        	$this->flash->addMessage('success', 'groups is deleted');
		
			$perms = Permissions::groupById($groupId);
			$perms->each(function($item){
				$item->delete();
			});
		}

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