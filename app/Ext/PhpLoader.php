<?php

namespace App\Ext;

use Symfony\Component\Config\Loader\FileLoader;

class PhpLoader extends FileLoader
{
    public function load($resource, $type = null)
    {
        return include $resource;
    }

    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'php' === pathinfo($resource, PATHINFO_EXTENSION);
    }
}