<?php
namespace Authentication\Model\Service;
          
use Util\Model\Service\Base\AbstractService;
use Zend\Db\Adapter\Adapter;
use Zend\Authentication\Adapter\DbTable;
use Zend\Authentication\AuthenticationService as ZendAuthService;
use Zend\Session\Container;

class AuthenticationService extends AbstractService
{   
    /**
     * Credentials' table
     * @var string 
     */
    protected $_table = 'auth_usuario';    
    
    /**
     * Default identity column
     * @var string 
     */
    protected $_identityColumn = 'us_usuario';
    
    /**
     * Default credential column
     * @var string
     */
    protected $_credentialColumn = 'us_password'; 
    
    
    /**
     * Default credential column
     * @var string
     */
    protected $_statusColumn = 'us_estado'; 
    
    /**
     *
     * @var \Zend\Authentication\AuthenticationService 
     */
    protected $_zendAuthService;
    
    /**
     *
     * @var \Zend\Authentication\Adapter\DbTable
     */
    protected $_dbTable;
    
    const NAMESPACE_SESSION = 'cit_session';
    
    const ENCRYPTION_YES = true;
    
    const ENCRYPTION_NO = false;
              
    public function __construct(Adapter $adapter) 
    {
        $storage = new \Zend\Authentication\Storage\Session(self::NAMESPACE_SESSION);
        
        $this->_zendAuthService = new ZendAuthService($storage);        
        $this->_dbTable = new DbTable($adapter);
        $this->_dbTable->setTableName($this->_table);
        $this->_dbTable
            ->setIdentityColumn($this->_identityColumn)                        
            ->setCredentialColumn($this->_credentialColumn);
            //->getDbSelect()->where(array($this->_statusColumn => 1));
    }
    
    public function getIdentityColumn()
    {
        return $this->_identityColumn;
    }
    
    public function getcredentialColumn()
    {
        return $this->_credentialColumn;
    }
    
    public function setCredentialColumns($identityColumn, $credentialColumn)
    {
        $this->_identityColumn = $identityColumn;
        $this->_credentialColumn = $credentialColumn;
        
        $this->_dbTable
            ->setIdentityColumn($identityColumn)                        
            ->setCredentialColumn($credentialColumn);            
    }
    
    public function authenticate($authData, $encryption = self::ENCRYPTION_YES)
    {
        try {
            $this->setCredentials($authData, $encryption);

            $result = $this->_zendAuthService->authenticate($this->_dbTable);

            if ($result->isValid()) {                    
                $this->_writeStorage($authData);                    
                return true;
            }
            
        } catch (\Exception $e) {
            $this->logout();            
            \Util\Common\Email::reportException($e);
        }

        return false;
    }
      
    public function setTimeout()
    {
        $config = $this->_sl->get('config');

        $session = new Container(self::NAMESPACE_SESSION); 
        $session->getManager()->rememberMe($config['session']['remember_me_seconds']);
        $session->setExpirationSeconds($config['session']['gc_maxlifetime']);
    }        
    
    private function _writeStorage($authData)
    {
        $method = 'getBy' . \Util\Common\String::prepareForMethod($this->getIdentityColumn());             
        $userData = $this->getUserService()->$method($authData[$this->getIdentityColumn()]);        
        unset($userData[$this->getcredentialColumn()]);            
        $this->_zendAuthService->getStorage()->write($userData);        
    }
    
    public function getUserService()
    {
        return $this->_sl->get('Model\AuthUsuario');
    }
    
    public function setCredentials($authData, $encryption)
    {      
        
        if ($encryption == true) {
            $credential = md5($authData[$this->getCredentialColumn()]);
        } else {
            $credential = $authData[$this->getCredentialColumn()];
        }
        
        $this->_dbTable
             ->setIdentity($authData[$this->getIdentityColumn()])
             ->setCredential($credential);
    }
        
    public function logout()
    {        
        $this->_zendAuthService->clearIdentity();       
    }
    
    /**
     * Returns true if and only if an identity is available from storage
     *
     * @return bool
     */
    public function hasIdentity()
    {
        return !$this->_zendAuthService->getStorage()->isEmpty();
    }

    /**
     * Returns the identity from storage or null if no identity is available
     *
     * @return mixed|null
     */
    public function getIdentity()
    {
        $storage = $this->_zendAuthService->getStorage();

        if ($storage->isEmpty()) {
            return null;
        }

        return $storage->read();
    }
    
    /**
     * Clears the identity from persistent storage
     *
     * @return void
     */
    public function clearIdentity()
    {
        $this->_zendAuthService->getStorage()->clear();
    }
    
    public function validRecover($email)
    {        
        $return = array(
            'success' => true,
            'data' => array('status' => 1),
        );
        
        $return['data']['message'] = 'Le hemos enviado un e-mail revíselo y siga las '
                            . 'instrucciones, revise también la carpeta de SPAM.';
        
        $userData = $this->getUserService()->getByEmail($email);        
        if (empty($userData)) {
            $return['success'] = false;
            $return['data']['message'] = 'El email ingresado no existe';
            $return['data']['status'] = 0;
        } else {
            if (empty($userData['status'])) {
                $return['success'] = false;
                $return['data']['message'] = 'El usuario fué deshabilitado';
                $return['data']['status'] = 0;
            }
        }
        
        return $return;
    }
}