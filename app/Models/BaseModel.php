<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
* 
*/
class BaseModel extends Model
{
	protected $validatorResult;
	protected $ruleMessages = [];

	public function save(array $options = [])
	{
		if( $this->rules && is_array($this->rules) ){
			$this->validatorResult = $this->validateFields($this->toArray());
			if( $this->isSuccess() ){
				return parent::save($options);
			} else {
				return false;
			}
		}
	}

	public function validateFields(array $arFields = [])
	{
		if( $this->rules && is_array($this->rules) ){
			if( method_exists($this, 'extRules') )
				$this->extRules();

			return $GLOBALS['container']->get('validator')->instance($arFields, $this->rules, $this->ruleMessages);
		}

		return $GLOBALS['container']->get('validator')->instance($arFields, []);
	}

	public function getErrors()
	{
		return $this->validatorResult->getErrors();
	}

	public function isSuccess()
	{
		return $this->validatorResult->isSuccess();
	}
}
