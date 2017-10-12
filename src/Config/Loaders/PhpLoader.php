<?php

namespace AppLib\Config\Loaders;

use Symfony\Component\Config\Loader\FileLoader;

class PhpLoader extends FileLoader
{
	public function load($resource, $type = NULL)
	{
		$file = $this->getLocator()->locate($resource);

        $preferences = require($file);
        
        if (!is_array($preferences)) {
            throw new \InvalidArgumentException(sprintf('The file "%s" must contain a PHP array.', $resource));
        }

        return $preferences;
	}

	public function supports($resource, $type = NULL)
	{
		return is_string($resource) && 'php' === pathinfo(
            $resource,
            PATHINFO_EXTENSION
        );
	}
}