<?php

//filename : Authentication/Module.php

namespace Authentication;

use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $app = $e->getParam('application');
        $app->getEventManager()->attach('dispatch', array($this, 'initAuth'), 100);
        
        $em = $e->getParam('application')->getEventManager();
        $em->attach('route', array($this, 'checkAuthenticated'));
    }

    public function isOpenRequest(MvcEvent $e) {
        if ($e->getRouteMatch()->getParam('controller') == 'Authentication\Controller\AuthController') {
            return true;
        }

        return false;
    }

    public function checkAuthenticated(MvcEvent $e) {
        $sm = $e->getApplication()->getServiceManager();
        if (!$sm->get('AuthService')->getStorage()->getSessionManager()
                        ->getSaveHandler()
                        ->read($sm->get('AuthService')->getStorage()->getSessionId())) {
            
            if ($e->getRouteMatch()->getParam('controller') != 'Authentication\Controller\Auth') {
                return $this->redirect($e,'/login');
            }
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return include __DIR__ . '/config/service.config.php';
    }
    
    public function getControllerConfig()
    {
        return include __DIR__ . '/config/controller.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__),
                ),
            ),
        );
    }
    
    /**
     * 
     * @param MvcEvent $e
     * @return \Authentication\Model\Service\AuthenticationService
     */
    protected function _getAuthenticationService(MvcEvent $e)
    {
        return $e->getApplication()
                ->getServiceManager()
                ->get('Authentication\Model\Service\AuthenticationService');
    }
    
    public function initAuth(MvcEvent $e)
    {  
        $data = $this->getControllerInfo($e);
        $authService = $this->_getAuthenticationService($e);        
        $app = $e->getApplication();       
        $viewModel = $app->getMvcEvent()->getViewModel();
       
        $viewModel->isAuth = $authService->hasIdentity();   
        if (!$authService->hasIdentity() 
            && empty($_SESSION['cit_session']['storage'])) {  
            $rol = \Sys\Entity\SysRecurso::ROL_INVITADO;
//            if (!$this->initAcl($e, $rol)) {
//                return $this->redirect($e);
//            }
        } elseif ($authService->hasIdentity() 
                || !empty($_SESSION['cit_session']['storage'])) {
            $user = $authService->getIdentity(); 
            
            $container = new Container('SBIIA');
            $container->user = $user;
            $viewModel->dataUser = $user;
            $viewModel->recurso = $data;
            
            $modelRecurso = $e->getApplication()->getServiceManager()
                    ->get('Model\SysRecurso');
            $dtaMenu = $modelRecurso->getMenuRolByRolId($user['rol_id']);
            $viewModel->sysMenu = $dtaMenu;
            //$this->checkUserEmail($e, $user);   
            if (!$this->initAcl($e, $user['rol_id'])) {
                return $this->redirect($e);
            }
        }
    }
    
    public function initAcl(MvcEvent $e, $rol)
    {
        $info = $this->getControllerInfo($e);
        $aclService = $e->getApplication()->getServiceManager()
                ->get('Authentication\Model\Service\AclService');
        $aclService->setResource($info['recurso']);
        $aclService->setRol($rol);
        //$data = $aclService->getRolService();
        //var_dump($data);exit;
        return $aclService->validate();
    }
    
    public function getControllerInfo($e)
    {
        $info = array();

        $matches = $e->getRouteMatch();

        $controllerPath = $matches->getParam('controller');
        $controllerArray = explode("\\", $controllerPath);
        
        $info['module'] = strtolower($controllerArray[0]);
        $info['controller'] = strtolower($controllerArray[2]);
        $info['action'] = strtolower($matches->getParam('action'));
        $info['recurso'] = $info['module'] . ':' . $info['controller'] . ':' . $info['action'];

        return $info;   
    }
    
    public function redirect($e, $url = '/login')
    {
        $response = $e->getResponse();
        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->setStatusCode(302);
        $response->sendHeaders();

        return $response;
    }

}
