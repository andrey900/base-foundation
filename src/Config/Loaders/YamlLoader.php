<?php

namespace AppLib\Config\Loaders;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

class YamlLoader extends FileLoader
{
    public function load($resource, $type = null)
    {
        $configValues = Yaml::parse(file_get_contents($this->getLocator()->locate($resource)), Yaml::PARSE_CONSTANT);

        return $this->useEnv($configValues);
    }

    public function supports($resource, $type = null)
    {
        return is_string($resource) && (
            'yml' === pathinfo(
                $resource,
                PATHINFO_EXTENSION
            ) 
            || 
            'yaml' === pathinfo(
                $resource,
                PATHINFO_EXTENSION
            )
        );
    }

    protected function useEnv(array $settings){
        foreach ($settings as &$value) {
            if( is_array($value) )
                $value = $this->useEnv($value);
            
            if( is_string($value) && substr($value, -2, 2) == ")%" && substr($value, 0, 5) == "%env(" ){
                $s = getenv(trim(substr($value, 5, -2)));
                if( is_string($s) ){
                    $value = ($s === "true" || $s === "false")?$this->returnBoolean($s):$s;
                } else {
                    $value = null;
                }
            }
        }

        return $settings;
    }

    protected function returnBoolean($s) {
       if( $s === "false" )
            return false;

        return true;
    }
}