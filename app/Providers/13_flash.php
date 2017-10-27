<?php

$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};