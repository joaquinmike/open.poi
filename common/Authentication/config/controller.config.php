<?php
return array(
    'factories' => array(
        'Authentication\Controller\Auth' => 'Authentication\Factory\Controller\AuthControllerServiceFactory'
    ),
    'invokables' => array(
        'Authentication\Controller\Success' => 'Authentication\Controller\SuccessController'
    ),
);