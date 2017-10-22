<?php

$app->group('/admin', function(){
	$this->get('/users', \Controllers\Admin\Users::class.':indexAction');
	$this->get('/users/{id:[0-9]+}', \Controllers\Admin\Users::class.':showAction');
	$this->get('/users/{id:[0-9]+}/edit', \Controllers\Admin\Users::class.':editAction');
	$this->get('/users/create', \Controllers\Admin\Users::class.':createAction');
	$this->post('/users', \Controllers\Admin\Users::class.':storeAction');
	$this->post('/users/{id:[0-9]+}', \Controllers\Admin\Users::class.':updelAction');
	$this->put('/users/{id:[0-9]+}', \Controllers\Admin\Users::class.':updateAction');
	$this->delete('/users/{id:[0-9]+}', \Controllers\Admin\Users::class.':destroyAction');
	$this->get('/users/{id:[0-9]+}/delete', \Controllers\Admin\Users::class.':destroyAction');
})->add( new App\Middleware\AuthMiddleware() );

$app->get('/admin/login', \Controllers\Admin\Auth::class.':indexAction');
$app->post('/admin/login', \Controllers\Admin\Auth::class.':loginAction');
$app->get('/admin/logout', \Controllers\Admin\Auth::class.':logoutAction');
$app->get('/admin/register', \Controllers\Admin\Auth::class.':createAction');
$app->post('/admin/signup', \Controllers\Admin\Auth::class.':storeAction');

$app->get('/admin/test', \Controllers\Admin\Test::class.':indexAction');
