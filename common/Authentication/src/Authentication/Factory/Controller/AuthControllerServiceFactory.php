<?php
//filename : module/Authentication/src/Authentication/Factory/Controller/AuthControllerServiceFactory.php
namespace Authentication\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Authentication\Controller\AuthController;

class AuthControllerServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $identityManager = $serviceLocator->getServiceLocator()->get('IdentityManager');
        $controller = new AuthController($identityManager);

        return $controller;
    }
}
