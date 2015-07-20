<?php

/**
 * Currency db AuthUsuario
 *
 * @author joaquinmike
 */

namespace Auth\Model;

use Util\Model\Repository\Base\AbstractRepository;


class AuthUsuario extends AbstractRepository {

    /**
     * @var String Name of db table
     */
    protected $_table = 'auth_usuario';

    /**
     * @var Adapter Db
     */
    public $adapter = null;

    /**
     * @var string or array of fields in table
     */
    protected $_primary = 'us_id';
    

    /**
     * Datos del usuario con login
     * @return type
     */
    public function getUsuarioLoginByUsId($usId){
        $select = $this->sql->select()->from(array('t1' => $this->_table))
                ->columns(array('us_id','us_usuario','us_email','us_estado'))
            ->where(array('t1.us_id = ?' => $usId));
        //echo $select->getSqlString();exit;
        return $this->fetchRow($select);
    }

}
