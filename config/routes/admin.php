<?php

$app->group('/admin', function(){
	$this->get('/users', \Controllers\Admin\Users::class.':indexAction');
	$this->get('/users/{id:[0-9]+}', \Controllers\Admin\Users::class.':showAction');
});