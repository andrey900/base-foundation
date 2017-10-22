<?php

namespace App\Controllers;

use Illuminate\Support\Collection;
use Monolog\Logger;
use Slim\Http\Response;
use Slim\Views\Twig;

/**
* 
*/
class BaseController
{
	protected $view;
	protected $logger;
	protected $settings;
	protected $viewCollection;

	public function __construct(Twig $view, Logger $log, $settings)
	{
		$this->view = $view;
		$this->logger = $log;
		$this->settings = $settings;

		$this->viewCollection = new Collection;

		if( $_SESSION['auth'] && $_SESSION['auth']->has('user.id')){
			$this->viewCollection['user'] = [
				'id' => $_SESSION['auth']['user.id'],
				'login' => $_SESSION['auth']['user.login'],
				'first_name' => $_SESSION['auth']['user.first_name'],
				'last_name' => $_SESSION['auth']['user.last_name'],
			];
		}
	}

	public function render($templateName)
	{
		return $this->view->render($this->response, $templateName, $this->viewCollection->toArray());
	}

	protected function request($request, $response)
	{
		$this->request = $request;
		$this->response = $response;
	}

	public function __call($name, $args){
		$this->request($args[0], $args[1]);
		$response = $this->$name($args[0], $args[1], $args[2]);
		if( $response instanceof Response ){
			return $response;
		} else {
			$tplName = strtolower(str_replace('Action', '', $name));	
			$type = strtolower(substr(get_called_class(), strrpos(get_called_class(), '\\')+1));
			return $this->render('pages/'.$type.'/'.$tplName.'.html');
		}
	}
}