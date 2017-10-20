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
});