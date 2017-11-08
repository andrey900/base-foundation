<?php

namespace App\Controllers\Backend;

use App\Ext\Kernel;
use App\Models\Groups as GroupsEntity;
use App\Models\Permissions as PermissionEntity;
use Facade\Collection;

class Permissions extends BaseAdminController
{
	protected function indexAction()
	{
		$permissions = PermissionEntity::all();

		$permissions = $permissions->where('module', 'route.name');
		$_permissions = $permissions->toArray();
		foreach ($permissions as $k => $item) {
			$_permissions[$k]['perms'] = $item->getPermissionsByName();
		}

		$this->viewCollection['permissions'] = $_permissions;
		$this->viewCollection['groups'] = GroupsEntity::all()->keyBy('id');
	}

	protected function showAction()
	{
		throw new \Exception("Error Processing Request, Method show not allowed", 1);
		
	}

	protected function editAction()
	{
		$this->viewCollection['permission'] = PermissionEntity::find($this->request->getAttribute('id'));
		$this->viewCollection['group'] = $this->viewCollection['permission']->group;
		$this->viewCollection['allow'] = Kernel::getInstance('settings')['settings']['permissions']['privileges']['access_route'];

        if( $formFields = $this->flash->getMessage('jsonFormData') ){
            $formFields = (array)json_decode($formFields[0]);
            $this->viewCollection['permission']->fill($formFields);
        }
	}

	protected function createAction()
	{
		$r = Kernel::getInstance('container')->get('router')->getRoutes();

		$routes = new Collection;

		foreach ($r as $route) {
			if( $route->getName() )
				$routes->push($route->getName());
		}

		$this->viewCollection['routes'] = $routes;
		$this->viewCollection['allow'] = Kernel::getInstance('settings')['settings']['permissions']['privileges']['access_route'];
		$this->viewCollection['groups'] = GroupsEntity::allActive();
	}

	protected function storeAction()
	{
        $formData = $this->request->getParsedBody();

		foreach ($formData['groups'] as $groupId) {
			$data = [
				'group_id' => $groupId,
				'module' => 'route.name',
				'permissions' => $formData['active'],
				'route' => $formData['route']
			];
			$permission = PermissionEntity::create($data);

			if( !$permission->isSuccess() ){
				foreach ($permission->getErrors() as $error) {
					$this->flash->addMessage('errors', $error);
				}
	            
	            $this->flash->addMessage('jsonFormData', json_encode($formData));

	            return $this->response->withRedirect('/admin/permissions/create');
	        }
		}
		
		$this->flash->addMessage('success', 'group is created');
		return $this->response->withRedirect('/admin/permissions');
	}

	protected function updateAction()
	{
		$data = $this->request->getParsedBody();
		$permission = PermissionEntity::find($this->request->getAttribute('id'));
		$permission->update($data);
		if( !$permission->isSuccess() ){
			foreach ($permission->getErrors() as $error) {
				$this->flash->addMessage('errors', $error);
			}
            
            $this->flash->addMessage('jsonFormData', json_encode($data));
            
			return $this->response->withRedirect('/admin/permissions/'.$permission->id.'/edit');
		} else {
			$this->flash->addMessage('success', 'permission is updated');
			return $this->response->withRedirect('/admin/permissions');
		}
	}

	protected function destroyAction()
	{
		PermissionEntity::destroy($this->request->getAttribute('id'));
		$this->flash->addMessage('success', 'permission is deleted');
		return $this->response->withRedirect('/admin/permissions');
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
