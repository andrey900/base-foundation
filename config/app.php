<?php

return [
	'test' => 'test'
];
/*
return [
	'settings' => [
		'displayErrorDetails' => true,
		'addContentLengthHeader' => false,
        'viewTemplatesDirectory' => '../templates',
    ],
    'twig' => [
        'title' => '',
        'description' => '',
        'author' => ''
    ],
    'view' => function ($c) {
        $view = new Twig(
            $c['settings']['viewTemplatesDirectory'],
            [
                'cache' => false // '../cache'
            ]
        );

        // Instantiate and add Slim specific extension
        $view->addExtension(
            new TwigExtension(
                $c['router'],
                $c['request']->getUri()
            )
        );

        foreach ($c['twig'] as $name => $value) {
            $view->getEnvironment()->addGlobal($name, $value);
        }

        return $view;
    }
/*    Home::class => function ($c) {
        return new Home($c['view']);
    }*//*
];
*/