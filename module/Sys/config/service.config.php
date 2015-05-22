<?php
namespace Sys;

return array(    
   'factories' => array(
        'Model\SysPartnersGateway' => function($serviceManager){
            return new Model\SysPartnersGateway( 
                    $serviceManager->get('Zend\Db\Adapter\Adapter'), 
                    $serviceManager
                );
        },
    ),
);