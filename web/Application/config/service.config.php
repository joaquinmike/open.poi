<?php
namespace Application;
use Util\Storage\DBStorage;
use Auth\Plugin\UserAuthentication;
use Zend\Authentication\Adapter\DbTable as DbAuthAdapter;
use Zend\Authentication\AuthenticationService;

use Auth\Model;

return array(    
   'factories' => array(
       'SessionDbStorage' => function ($serviceManager) {
            $config = $serviceManager->get('Config');
            return new DBStorage($serviceManager->get('Zend\Db\Adapter\Adapter')
                    , $config['session']['sessionConfig']);
        },
       'UserAuthentication' => function ($serviceManager) {
            $adapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
            $dbAuthAdapter = new DbAuthAdapter($adapter, 'auth_users', 'username', 'password', 'MD5(?)');
            $auth = new AuthenticationService();
            $auth->setAdapter($dbAuthAdapter);
            $UserAutentication = new UserAuthentication();
            $UserAutentication->setAuthAdapter($dbAuthAdapter);
            $UserAutentication->setAuthService($auth);
            return $UserAutentication;
        },
    ),
);