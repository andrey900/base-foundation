<?php

namespace AppLib;

use Slim\Views\Twig as TwigOrigin;

/**
* 
*/
class Twig extends TwigOrigin
{
	public function setEnvironment($env)
	{
		$this->environment = $env;
	}
}