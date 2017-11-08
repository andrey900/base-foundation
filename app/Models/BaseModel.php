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
		if( method_exists($this, 'extRules') )
			$this->extRules();
		
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

	public function validateFields(array $arFields = [])
	{
		if( $this->rules && is_array($this->rules) ){
			return Kernel::getInstance('container')->get('validator')->instance($arFields, $this->rules, $this->ruleMessages);
		}

		return Kernel::getInstance('container')->get('validator')->instance($arFields, []);
	}

	public function getErrors()
	{
		if( $this->rules )
			return $this->validatorResult->getErrors();
		
		return [];
	}

	public function isSuccess()
	{
		if( $this->rules )
			return $this->validatorResult->isSuccess();

		return true;
	}
}
