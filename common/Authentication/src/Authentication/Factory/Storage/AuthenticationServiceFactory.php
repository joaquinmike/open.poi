<?php
//filename : module/Authentication/src/Authentication/Factory/Storage/AuthenticationServiceFactory.php
namespace Authentication\Factory\Storage;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class AuthenticationServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter, 'auth_usuario','us_usuario','us_password', 'MD5(?)');

        $authService = new AuthenticationService($serviceLocator->get('AuthStorage'), $dbTableAuthAdapter);

        return $authService;
    }
}
