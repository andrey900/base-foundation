<?php

namespace AppLib\Config;

use Symfony\Component\Filesystem\Filesystem;

/**
* 
*/
class ConfigLoader
{
	protected $filesystem;

	public function __construct()
	{
		$this->filesystem = new Filesystem();
	}
}