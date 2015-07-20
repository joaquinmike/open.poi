<?php

/**
 * Currency db AuthRecurso
 *
 * @author joaquinmike
 */

namespace Auth\Model;

use Util\Model\Repository\Base\AbstractRepository;


class AuthRecurso extends AbstractRepository {

    /**
     * @var String Name of db table
     */
    protected $_table = 'auth_recurso';

    /**
     * @var Adapter Db
     */
    public $adapter = null;

    /**
     * @var string or array of fields in table
     */
    protected $_primary = 'rec_id';
    
    public function getMenuRolByRolId($rolId){
        $select = $this->sql->select()->from(array('t1' => $this->_table))
              ->columns(array('rec_id','rec_desc','rec_uri','rec_rec_id','rec_css'))
              ->join(array('t2' => 'auth_rol_recurso'), 't1.rec_id = t2.rec_id', array('rolrec_permiso'))
              ->where(array('t1.rec_estado = ?' => \Application\Entity\Functions::ESTADO_ACTIVO))
              ->where(array('t1.rec_tipo = ?' => \Auth\Entity\AuthRecurso::TIPO_MENU))
              ->where(array('t2.rolrec_permiso = ?' => \Auth\Entity\AuthRecurso::ESTADO_PERMISO))
              ->where(array('t2.rol_id = ?' => $rolId))
              ->order(array('rec_rec_id','rec_orden'));
          //echo $select->getSqlString();exit;
        return $this->fetchAll($select);
    }
    
}