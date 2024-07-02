<?php

namespace Testing;

use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
            Controller\UploadController::class => ReflectionBasedAbstractFactory::class
        ],
    ],
    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'testing.upload' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/testing/upload[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\UploadController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager'=> [
        'factories'=> [
            Service\ImageManager::class => InvokableFactory::class,
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'testing' => __DIR__ . '/../view',
        ],
    ],
];