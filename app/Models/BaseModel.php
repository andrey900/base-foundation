<?php

namespace App\Models;

use App\Ext\Kernel;
use App\Ext\PermissionsValidator;
use Illuminate\Database\Eloquent\Model;

/**
* 
*/
class BaseModel extends Model
{
	protected $ruleMessages = [];
	protected $validatorResult;
	protected $permissionResult = false;

	public function save(array $options = [])
	{
		$type = 'create';
		if( $this->id )
			$type = 'write';

		if( !$this->checkPermission($type) ){
			return $this;
		}

		if( $this->rules && is_array($this->rules) ){
			$this->validatorResult = $this->validateFields($this->toArray());
			if( $this->isSuccess() ){
				return parent::save($options);
			} else {
				return $this;
			}
		} else {
			return parent::save($options);
		}
	}

	public function delete()
	{
		if( !$this->checkPermission('delete') ){
			return $this;
		}
	}

/*	public function newInstance($attributes = [], $exists = false)
	{
		$model = parent::newInstance($attributes = [], $exists = false);
		
		if( !$this->checkPermission('read') ){
			return false;
		}
		
		return $model;
	}*/

	public function validateFields(array $arFields = [])
	{
		if( $this->rules && is_array($this->rules) ){
			if( method_exists($this, 'extRules') )
				$this->extRules();

			return Kernel::getInstance('container')->get('validator')->instance($arFields, $this->rules, $this->ruleMessages);
		}

		return Kernel::getInstance('container')->get('validator')->instance($arFields, []);
	}

	public function getErrors()
	{
		if( !$this->permissionResult )
			return ['Permission denied'];

		return $this->validatorResult->getErrors();
	}

	public function isSuccess()
	{
		if( !$this->permissionResult )
			return false;

		return $this->validatorResult->isSuccess();
	}

	public function checkPermission($type)
	{
		$user = Kernel::getInstance('user');
		if($user->isAdmin()){
			$this->permissionResult = true;
			return $this->permissionResult;
		}

		$permValidator = new PermissionsValidator;

		$this->permissionResult = $permValidator->isAllowed($this->table.'.model', $type);
		
		return $this->permissionResult;
	}
}
