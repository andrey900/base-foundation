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

    $this->get('/groups', \Controllers\Admin\Groups::class.':indexAction');
    $this->get('/groups/{id:[0-9]+}', \Controllers\Admin\Groups::class.':showAction');
    $this->get('/groups/{id:[0-9]+}/edit', \Controllers\Admin\Groups::class.':editAction');
    $this->get('/groups/create', \Controllers\Admin\Groups::class.':createAction');
    $this->post('/groups', \Controllers\Admin\Groups::class.':storeAction');
    $this->post('/groups/{id:[0-9]+}', \Controllers\Admin\Groups::class.':updelAction');
    $this->put('/groups/{id:[0-9]+}', \Controllers\Admin\Groups::class.':updateAction');
    $this->delete('/groups/{id:[0-9]+}', \Controllers\Admin\Groups::class.':destroyAction');
    $this->get('/groups/{id:[0-9]+}/delete', \Controllers\Admin\Groups::class.':destroyAction');
})->add( new App\Middleware\AuthMiddleware() );

$app->get('/admin/login', \Controllers\Admin\Auth::class.':indexAction');
$app->post('/admin/login', \Controllers\Admin\Auth::class.':loginAction');
$app->get('/admin/logout', \Controllers\Admin\Auth::class.':logoutAction');
$app->get('/admin/register', \Controllers\Admin\Auth::class.':createAction');
$app->post('/admin/signup', \Controllers\Admin\Auth::class.':storeAction');

$app->get('/admin/test', \Controllers\Admin\Test::class.':indexAction');
