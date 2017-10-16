<?php

namespace AppLib;

use DebugBar\Bridge\Twig\TraceableTwigEnvironment as TraceableTwigEnvironmentDebugBar;
use DebugBar\Bridge\Twig\TraceableTwigTemplate;

/**
* 
*/
class TraceableTwigEnvironment extends TraceableTwigEnvironmentDebugBar
{
	public function loadTemplate($name, $index = null)
    {
    	$cls = $this->twig->getTemplateClass($name, $index);

    	if (isset($this->twig->loadedTemplates[$cls])) {
            return $this->twig->loadedTemplates[$cls];
        }

    	$templates = $this->twig->loadTemplate($name, $index);
    	p($templates);
    	$this->loadedTemplates[$cls] = new TraceableTwigTemplate($this, $templates);
    	// $this->loadedTemplates[$cls] = false;
    	// $this->loadedTemplates[$cls] = $templates;
    	return $templates;
    }
}