<?php
namespace Authentication;

return array(
    'factories' => array(         
        'AuthStorage' => 'Authentication\Factory\Storage\AuthStorageFactory',
        'AuthService' => 'Authentication\Factory\Storage\AuthenticationServiceFactory',
        'IdentityManager' => 'Authentication\Factory\Storage\IdentityManagerFactory',
        'Authentication\Model\Service\AuthenticationService' => 'Authentication\Model\Service\Factory\AuthenticationFactory',
        'Authentication\Model\Service\AclService' => 'Authentication\Model\Service\Factory\AclFactory',
        
        'Form\LoginForm' => function($sm){
            $adapter = $sm->get('Zend\Db\Adapter\Adapter');
            return new Form\LoginForm($adapter, $sm);
        },
     ),
                
    'invokables' => array(
    ),
);