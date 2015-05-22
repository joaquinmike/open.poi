<?php

namespace Yoson;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface,    
    Zend\ModuleManager\Feature\ConfigProviderInterface,
    Zend\Mvc\MvcEvent,
    Zend\Mvc\Router\RouteMatch;
class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $callback = function (MvcEvent $event) {
            $view = $event->getApplication()->getServiceManager()->get('ViewRenderer');
            $config = $event->getApplication()->getConfig();
            $controller = $event->getTarget();
            
            $rm = $event->getRouteMatch();
            if(!($rm instanceof RouteMatch)){
                $rm = new RouteMatch(
                    array(
                        'module'        => 'Application',
                        '__NAMESPACE__' => 'Application\Controller',
                        '__CONTROLLER__'=> 'index',
                        'controller'    => 'Application\Controller\Index',
                        'action'        => 'index',
                    )
                );
            }
            
            $params = $rm->getParams();
//            var_dump($rm->getMatchedRouteName());
//            var_dump($params); exit;
            $modulo = "";            
            if (isset($params['__NAMESPACE__'])) {
                $paramsArray = explode("\\", $params['__NAMESPACE__']);
                $modulo = $paramsArray[0];
            }
            $controller = isset($params['__CONTROLLER__'])?$params['__CONTROLLER__']:"";

            $action = $params['action'];
            $app = $event->getParam('application');
            $sm = $app->getServiceManager();
                                   
            $paramsConfig = array(
                'modulo' => strtolower($modulo),
                    'controller'        => strtolower($controller),
                    'action'            => strtolower($action),
                    'baseHost'          => $view->base_path("/"),
                    'statHost'          => $view->server('static'),
                    'eHost'             => $view->server('element'),
                    'cssStaticHost'     => $view->server('static', 'css', false),
                    'jsStaticHost'      => $view->server('static', 'js', false),                    
                    'statVers'          => $config['servers']['static']['version'],
                    'min'               => '',                   
                    'AppCore'           => array(),
                    'AppSandbox'        => array(),
                    'AppSchema'         => array('modules' => array(), 'requires'=> array()),                    
            );

            $view->inlineScript()->appendScript(
                "var yOSON=" . json_encode($paramsConfig, JSON_FORCE_OBJECT)
            );
        };

        $e->getApplication()->getEventManager()->getSharedManager()->attach(
            'Zend\Mvc\Controller\AbstractActionController', MvcEvent::EVENT_DISPATCH, $callback , 100
        );

        $e->getApplication()->getEventManager()->getSharedManager()->attach(
            'Zend\Mvc\Application', MvcEvent::EVENT_DISPATCH_ERROR, $callback , 100
        );
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
            
//            'Zend\Loader\ClassMapAutoloader' => array(
//                __DIR__ . '/autoload_classmap.php',
//            )
        );
    }
}