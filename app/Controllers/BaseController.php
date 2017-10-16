<?php

namespace App\Controllers;

use Monolog\Logger;
use Slim\Views\Twig;
use Illuminate\Support\Collection;

/**
* 
*/
class BaseController
{
	protected $view;
	protected $logger;
	protected $viewCollection;

	public function __construct(Twig $view, Logger $log)
	{
		$this->view = $view;
		$this->logger = $log;
		$this->viewCollection = new Collection;
	}

	public function render($templateName)
	{
		return $this->view->render($this->response, $templateName, $this->viewCollection->toArray());
	}

	protected function request($request, $response)
	{
		$this->logger->addInfo("Something interesting happened");
		$this->request = $request;
		$this->response = $response;
	}
}