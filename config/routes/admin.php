<?php

$app->group('/admin', function(){
    $this->get('/users', \Controllers\Admin\Users::class.':indexAction')->setName('admin.users.index');
    $this->get('/users/{id:[0-9]+}', \Controllers\Admin\Users::class.':showAction')->setName('admin.users.show');
    $this->get('/users/{id:[0-9]+}/edit', \Controllers\Admin\Users::class.':editAction')->setName('admin.users.edit');
    $this->get('/users/create', \Controllers\Admin\Users::class.':createAction')->setName('admin.users.create');
    $this->post('/users', \Controllers\Admin\Users::class.':storeAction')->setName('admin.users.store');
    $this->post('/users/{id:[0-9]+}', \Controllers\Admin\Users::class.':updelAction')->setName('admin.users.fakerest');
    $this->put('/users/{id:[0-9]+}', \Controllers\Admin\Users::class.':updateAction')->setName('admin.users.update');
    $this->delete('/users/{id:[0-9]+}', \Controllers\Admin\Users::class.':destroyAction')->setName('admin.users.destroy.rest');
    $this->get('/users/{id:[0-9]+}/delete', \Controllers\Admin\Users::class.':destroyAction')->setName('admin.users.destroy');

    $this->get('/groups', \Controllers\Admin\Groups::class.':indexAction')->setName('admin.groups.index');
    $this->get('/groups/{id:[0-9]+}', \Controllers\Admin\Groups::class.':showAction')->setName('admin.groups.show');
    $this->get('/groups/{id:[0-9]+}/edit', \Controllers\Admin\Groups::class.':editAction')->setName('admin.groups.edit');
    $this->get('/groups/create', \Controllers\Admin\Groups::class.':createAction')->setName('admin.groups.create');
    $this->post('/groups', \Controllers\Admin\Groups::class.':storeAction')->setName('admin.groups.store');
    $this->post('/groups/{id:[0-9]+}', \Controllers\Admin\Groups::class.':updelAction')->setName('admin.groups.fakerest');
    $this->put('/groups/{id:[0-9]+}', \Controllers\Admin\Groups::class.':updateAction')->setName('admin.groups.update');
    $this->delete('/groups/{id:[0-9]+}', \Controllers\Admin\Groups::class.':destroyAction')->setName('admin.groups.destroy.rest');
    $this->get('/groups/{id:[0-9]+}/delete', \Controllers\Admin\Groups::class.':destroyAction')->setName('admin.groups.destroy');

    $this->get('/permissions', \Controllers\Admin\Permissions::class.':indexAction')->setName('admin.permissions.index');
    $this->get('/permissions/{id:[0-9]+}', \Controllers\Admin\Permissions::class.':showAction')->setName('admin.permissions.show');
    $this->get('/permissions/{id:[0-9]+}/edit', \Controllers\Admin\Permissions::class.':editAction')->setName('admin.permissions.edit');
    $this->get('/permissions/create', \Controllers\Admin\Permissions::class.':createAction')->setName('admin.permissions.create');
    $this->post('/permissions', \Controllers\Admin\Permissions::class.':storeAction')->setName('admin.permissions.store');
    $this->post('/permissions/{id:[0-9]+}', \Controllers\Admin\Permissions::class.':updelAction')->setName('admin.permissions.fakerest');
    $this->put('/permissions/{id:[0-9]+}', \Controllers\Admin\Permissions::class.':updateAction')->setName('admin.permissions.update');
    $this->delete('/permissions/{id:[0-9]+}', \Controllers\Admin\Permissions::class.':destroyAction')->setName('admin.permissions.destroy.rest');
    $this->get('/permissions/{id:[0-9]+}/delete', \Controllers\Admin\Permissions::class.':destroyAction')->setName('admin.permissions.destroy');
})->add( new App\Middleware\AuthMiddleware() );

$app->get('/admin/login', \Controllers\Admin\Auth::class.':indexAction');
$app->post('/admin/login', \Controllers\Admin\Auth::class.':loginAction');
$app->get('/admin/logout', \Controllers\Admin\Auth::class.':logoutAction');
$app->get('/admin/register', \Controllers\Admin\Auth::class.':createAction');
$app->post('/admin/signup', \Controllers\Admin\Auth::class.':storeAction');

$app->get('/admin/test', \Controllers\Admin\Test::class.':indexAction');
