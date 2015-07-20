<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'php' => array(
        'settings' =>
            array(
                'date.timezone' => 'America/Lima',
                'intl.default_locale' => 'es_PE',
                'display_startup_errors' => true,
                'display_errors' => true,
                'error_reporting' => E_ALL,
                'post_max_size' => '804857600',  
            )
    ),    
    'error' => array(
        'send_mail' => false,
        'local_log' => true,        
    ),
    'view_manager' => array(
        'base_path' => "http://dev.open-poi.pe/",
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'charset' => 'UTF-8',
        'doctype' => 'HTML5',
        'title' => 'Cit',
        'strategies' => array(
           'ViewJsonStrategy',
        ),
    ),
    'module_layouts' => array(
        'Web' => 'layout/web/layout.phtml',
        'Authentication' => 'layout/authentication/layout.phtml',
       
    ),
    //Parámetros de la applicación
    'app' => array(                
    ),
    
    
    'mail' => array(
        'transport' => array(
            'options' => array(
                'host' => 'smtp.gmail.com',
                'port' => 587,
                'connection_class'  => 'login',
                'connection_config' => array(
                    'username' => 'techstartercompany@gmail.com',
                    'password' => 'Cistensure1',
                    'ssl' => 'tls',
                ),
            ),
        ),
        'fromEmail' => 'techstartercompany@gmail.com',
        'fromName' => 'TS-Videl',
        'subject' => 'TS - Videl - subject'
    ),
    
    // Mail messages (subjets)
    'mailMessages' => array(
        'payment' => array(
            'confirmation' => 'Confirmación de pago',
            'cancelation' => 'Cancelación de pago',
        ),
    ),
                
    //Emails
    'emails' => array(
        'admin' => 'ing.angeljara@gmail.com', // email del administrador
        'developers' => 'ing.angeljara@gmail.com', // emails de los dev
        'from' => 'contacto@techstarter.pe',
    ), 
    
    //Servers
    'servers' => array(
        'static' => array(
            'host' => 'http://dev.open-poi.pe/',
            'version' => '?v1.1'
        ),
        'element' => array(
            'host' => 'http://dev.open-poi.pe/',                
        ),
        'content' => array(
            'host' => 'http://dev.open-poi.pe/',                
        ),            
    ), 
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
        'abstract_factories' => array(
            'Zend\Db\Adapter\AdapterAbstractServiceFactory',
        ),
    ),
    
   'session'=>array(
        'sessionConfig' => array(
            'cache_expire' => 86400,
            'cookie_domain' => 'dev.open-poi.pe',
            'name' => 'SESSION_POI',
            'cookie_lifetime' => 190000,
            'gc_maxlifetime' => 190000,
            'cookie_path' => '/',
            'cookie_secure' => TRUE,
            'remember_me_seconds' => 7600,
            'use_cookies' => true,
        ),
        'serviceConfig'=>array(
            'base64Encode'=>false
        )
    ),
    'locales' => array(
        'default' => array(
            'code' => isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : 'es'
        ),
        'list' => array(
            'en' => array('code' => 'en', 'name' => 'United Kingdom / English', 'index' => 0),
            'es' => array('code' => 'es', 'name' => 'Espa&ntilde;a / Espa&ntilde;ol', 'index' => 4),
        )
    ),
    'caches' => array(
        'cache' => array(
            'adapter' => array(
                'name' => 'filesystem',
                'options' => array(
                    'dirLevel' => 2,
                    'cacheDir' => 'data/cache',
                    'dirPermission' => 0755,
                    'filePermission' => 0666,
                    'namespaceSeparator' => '-db-'
                ),
            ),
            'plugins' => array('serializer')
        ),
        'mencached' => array()
    ),
    'authentication' => array(        
        'acl' => array(
            'resources' => array(            
                'public' => array(
                    'authentication:auth:index',
                    'application:test:index',
                ),
            ),
        ),
    ),
   
  
);