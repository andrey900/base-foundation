<?php

$container['Controllers\\Home'] = $container->get('controllerFactory')->instance('Home');
$container['Controllers\\Admin\\Users'] = $container->get('controllerFactory')->instance('Users', 'b');
$container['Controllers\\Admin\\Auth'] = $container->get('controllerFactory')->instance('Auth', 'b');
$container['Controllers\\Admin\\Test'] = $container->get('controllerFactory')->instance('Test', 'b');