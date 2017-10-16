<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

/*$app->get('/', function (Request $request, Response $response) {
    $this->logger->addInfo("Something interesting happened");
    // return $response;
    return $this->view->render($response, 'profile.html');
})->setName('index');*/

$app->get('/', \Controllers\Home::class.':home');