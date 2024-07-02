<?php

namespace Contact;

use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Contact\Model\ContactTableFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
            Controller\ContactController::class => ReflectionBasedAbstractFactory::class
        ],
    ],
    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'contact' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/contact[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ContactController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'contact' => __DIR__ . '/../view',
        ],
        'strategies'=> [
            'ViewJsonStrategy'
        ]
    ],
    'service_manager' => [
        'factories' => [
            Model\ContactTable::class => ContactTableFactory::class,
        ],

    ],
];