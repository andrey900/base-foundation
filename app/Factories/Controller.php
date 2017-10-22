<?php

namespace App\Factories;

/**
* 
*/
class Controller
{
	protected $c;

	public function __construct($container)
	{
		$this->c = $container;
	}

	public function instance($name, $type = 'f')
	{
		$_type = ($type == 'b') ? 'Backend' : 'Frontend';
		$clName = '\\App\\Controllers\\'.$_type.'\\'.$name;
		$controller = new $clName(
			$this->c->get("view"), 
			$this->c->get("logger"),
			$this->c->settings
		);

		return $controller;
	}
}