<?php

namespace AppLib;

use DebugBar\Bridge\Twig\TraceableTwigTemplate as TraceableTwigTemplateDebugBar;

class TraceableTwigTemplate extends TraceableTwigTemplateDebugBar
{
	public function getDebugInfo(){}
}