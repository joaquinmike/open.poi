<?php

//filename : Authentication/config/module.config.php
namespace Authentication;

return array(

    //controllers services...
//    'controllers' => array(
//        'factories' => array(
//            'Authentication\Controller\Auth' => 'Authentication\Factory\Controller\AuthControllerServiceFactory'
//        ),
//        'invokables' => array(
//            'Authentication\Controller\Success' => 'Authentication\Controller\SuccessController'
//        ),
//    ),

    //register auth services...
//    'service_manager' => array(
//        'factories' => array(
//            'AuthStorage' => 'Authentication\Factory\Storage\AuthStorageFactory',
//            'AuthService' => 'Authentication\Factory\Storage\AuthenticationServiceFactory',
//            'IdentityManager' => 'Authentication\Factory\Storage\IdentityManagerFactory',
//        ),
//    ),

    //routing configuration...
    'router' => array(
        'routes' => array(

            'auth' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/auth[/:action]',
                    'defaults' => array(
                        'controller' => 'Authentication\Controller\Auth',
                        'action'     => 'index',
                    ),
                ),
            ),

            'success' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/success[/:action]',
                    'defaults' => array(
                        'controller' => 'Authentication\Controller\Success',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    //setting up view_manager
    'view_manager' => array(
        'template_path_stack' => array(
            'Authentication' => __DIR__ . '/../view',
        ),
    ),
);
