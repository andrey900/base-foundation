<?php

namespace App\Factories;

use SimpleValidator\Validator;

/**
* 
*/
class Validation
{
	protected $c;

	public function __construct($container)
	{
		$this->c = $container;
	}

	public function instance(array $data, array $rules, array $errorsText = [])
	{
		$validation_result = Validator::validate($data, $rules);
		if( $errorsText )
			$validation_result->customErrors($errorsText);
		
		return $validation_result;
	}
}