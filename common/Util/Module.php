<?php
namespace Util;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $this->initTranslate($e);
        $this->trailingSlash($e);
        
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return include __DIR__ . '/config/service.config.php';
    }
    
    public function getControllerPluginConfig()
    {       
        return include __DIR__ . '/config/plugin.config.php';
    }
    
    public function getViewHelperConfig()
    {       
        return include __DIR__ . '/config/helper.config.php';
    }
    
    public function initTranslate($e)
    {
        $dir = __DIR__ . '/translate/formMessages.php';
        $type = 'phpArray';

        $translator = $e->getApplication()->getServiceManager()->get('translator');
        $translator->addTranslationFile($type, $dir);
        AbstractValidator::setDefaultTranslator($translator);        
    }
    
    public function trailingSlash($e)
    {
        if (PHP_SAPI == "cli") {
            return;
        }
        
        $request = $e->getApplication()
                ->getServiceManager()
                ->get('Request');

        $uri = $request->getUri();

        if ($uri->getPath() !== '/') {
            $path = strrev($uri->getPath());

            if ($path[0] === '/') {
                $path = substr_replace(strrev($path), '', strlen($path) - 1);
                $uri->setPath($path);
            }
        }
    }
}