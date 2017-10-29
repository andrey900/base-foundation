<?php

namespace App\Controllers\Backend;

use Monolog\Logger;
use Slim\Views\Twig;
use Slim\Http\Response;
use Slim\Flash\Messages;
use Illuminate\Support\Collection;
use App\Controllers\BaseController;

/**
* 
*/
class BaseAdminController extends BaseController
{
	/*protected $view;
	protected $logger;
	protected $settings;
	protected $flash;
	protected $viewCollection;

	public function __construct(Twig $view, Logger $log, $settings)
	{
        
		$this->view = $view;
		$this->logger = $log;
		$this->settings = $settings;

		$this->viewCollection = new Collection;

		if( $this->session['auth'] && $this->session['auth']->has('user.id')){
			$this->viewCollection['user'] = [
				'id' => $this->session['auth']['user.id'],
				'login' => $this->session['auth']['user.login'],
				'first_name' => $this->session['auth']['user.first_name'],
				'last_name' => $this->session['auth']['user.last_name'],
			];
		}
	}

	public function setFlash(Messages $flash)
	{
		$this->flash = $flash;
		if( $this->flash->getMessage('errors') ){
			$this->viewCollection['errors'] = $this->flash->getMessage('errors');
		}
		if( $this->flash->getMessage('success') ){
			$this->viewCollection['success'] = $this->flash->getMessage('success');
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
	}*/
}