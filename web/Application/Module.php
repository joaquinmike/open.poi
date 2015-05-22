<?php

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\Parameters;;
use Util\Common\Filter;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {                 
        $app = $e->getParam('application');
        $app->getEventManager()->attach('dispatch', array($this,'initEnvironment'), 100);   
        $app->getEventManager()->attach('dispatch', array($this,'initViewRender'), 100);
        $app->getEventManager()->attach('dispatch', array($this,'initCleanRequestParams'), 100);
        
        $app->getEventManager()->attach('dispatch.error', array($this,'initError'), 100);
                      
        $this->initLayoutVariables($e);       
        
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);        
        
        // Redirecciona al Home si es error 404
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, function(MvcEvent $event) {
            $modulo = new Module();
            $error = $event->getResult();                        
            if ($error->message == 'Page not found.') {
                $modulo->redirecciona($event);
            }            
        });  
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
    
    public function getControllerConfig()
    {        
        return include __DIR__ . '/config/controller.config.php';
    }
    
    public function getServiceConfig()
    {
        return include __DIR__ . '/config/service.config.php';
    }
    
    public function getViewHelperConfig()
    {       
        return include __DIR__ . '/config/helper.config.php';
    }
            
    public function initCleanRequestParams(MvcEvent $e)
    {
        
    }
    
    public function initLayoutVariables(MvcEvent $e)
    {        
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->getSharedManager()
            ->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) 
            {
               $controller      = $e->getTarget();
                $controllerClass = get_class($controller);
                $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
                $config          = $e->getApplication()->getServiceManager()->get('config');
                if (isset($config['module_layouts'][$moduleNamespace])) {
                    $controller->layout($config['module_layouts'][$moduleNamespace]);
                }
        }, 100);
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function initViewRender($e)
    {
        $app = $e->getApplication();
        $config = $app->getServiceManager()->get('config');
        //$modelParters =  $app->getServiceManager()->get('Model\SysPartners');
        $viewRender = $app->getServiceManager()->get('ViewManager')->getRenderer();
        $viewConfig = $config['view_manager'];
        $matches = $e->getRouteMatch();
        $viewModel = $app->getMvcEvent()->getViewModel();
        $viewModel->aliasPartner = $matches->getParam('alias');
        
        //$viewModel->partnerData = $modelParters->getBy(array('partner_slug=?' => $viewModel->aliasPartner));;
        $viewRender->headTitle($viewConfig['title']);
        $viewRender->headMeta()->setCharset($viewConfig['charset']);
        $viewRender->doctype($viewConfig['doctype']);
    }
    
    public function initEnvironment($e)
    {           
       $app = $e->getParam('application');
       $config = $app->getServiceManager()->get('config');
       $settings = $config['php']['settings'];
       
       foreach ($settings as $key => $setting) {
           if ($key == 'error_reporting') {
               error_reporting($setting);
               continue;
           }

           ini_set($key, $setting);
       }
    }
    
    public function initError(MvcEvent $e)
    {
        $app = $e->getParam('application');

        $viewModel = $e->getViewModel();
        $viewModel->setTemplate('layout/error');

        $config = $app->getServiceManager()->get('config');
        
        if (!is_null($e->getParam('exception'))) {            
            $logConfig = $config['error'];
            $log = new \Util\Model\Service\ErrorService();

            if ($logConfig['send_mail']) {                
                try {                                       
                    \Util\Common\Email::reportException($e->getParam('exception'));                    
                } catch (\Exception $exception) {                    
                    $log->logException($exception);
                }
            }

            if ($logConfig['local_log']) {
                $log->logException($e->getParam('exception'));
            }                        
        }
        
        //no debe exitir error en home, para que no entre en bucle infinito
        if ($config['php']['settings']['display_errors'] != true) {
            $this->redirecciona($e);
        }
        
    }        
    
    public function redirecciona($event)
    {
        /*$url = $event->getRouter()->assemble(array('action' => 'index'), array('name' => 'application'));
        $response = $event->getResponse();
        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->setStatusCode(302);
        $response->sendHeaders();
        */
        //return $response;
    }
}
