<?php

$container['Controllers\\Home'] = $container->get('controllerFactory')->instance('Home');
$container['Controllers\\Admin\\Users'] = $container->get('controllerFactory')->instance('Users', 'b');