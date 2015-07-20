<?php

/**
 * Currency db AuthRolRecurso
 *
 * @author joaquinmike
 */

namespace Auth\Model;

use Util\Model\Repository\Base\AbstractRepository;


class AuthRolRecurso extends AbstractRepository {

    /**
     * @var String Name of db table
     */
    protected $_table = 'auth_rol_recurso';

    /**
     * @var Adapter Db
     */
    public $adapter = null;

    /**
     * @var string or array of fields in table
     */
    protected $_primary = array('rol_id','rec_id');
    
    public function getPermissions()
    {
        return $this->getAllRolPermissions();
    }
    
    public function getAllRolPermissions() 
    {
       $select = $this->sql->select()->from(array('t1' => $this->_table))
            ->columns(array('rolrec_permiso','rol_id'))
            ->join(array('t2' => 'auth_recurso'), 't1.rec_id = t2.rec_id',array('rec_id','rec_uri'));
        $recursos =  $this->fetchAll($select);
        $response = array();
        if (!empty($recursos)) {
            foreach ($recursos as $value) {
                $response[$value['rol_id']][$value['rec_id']] = array(
                    'rec_id' => $value['rec_id'],
                    'rec_uri' => $value['rec_uri'],
                    'rol_permiso' => $value['rolrec_permiso']
                );
            }
        }
        return $response;
    }
}