<?php

namespace Sys\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

class SysIdiomas extends AbstractTableGateway 
{

    /**
     * @var String Name of db table
     */
    protected $table = 'sys_idiomas';

    /**
     * @var Adapter Db
     */
    public $adapter = null;

    /**
     * @var string or array of fields in table
     */
    protected $_primary = 'idioma_id';
    protected $_service;

    /**
     * Retorna el partner por id de partner.
     * @param type $id
     * @return type
     */
    public function getById($id) {

        $responce = $this->select(array("$this->_primary=?" => $id))->current();
        return $responce;
    }
    
     /**
     * retirna todos los conuntries
     * @return type
     */
    public function getAll($order = 'idioma_nombre') {
        $key = $this->table . '_all';
        $result = $this->_service->get('Cache')->getItem($key);
        if (!empty($result)) {
           return $result;
        }        
        $adapter = $this->getAdapter();
        $sql = new Sql($adapter);
        $select = $sql->select()->from(array('t1' => $this->table))
                ->columns(array('*'))
                ->order($order);
        $selectString = $sql->getSqlStringForSqlObject($select);
        $result = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE)->toArray();
        $this->_service->get('Cache')->addItem($key, $result);
        return $result;
    }


    /**
     * Actuliza varios registros
     * @param array $params
     */
    public function inserTable(array $params = array()) {
        try {
            $this->getAdapter()->getDriver()->getConnection()->beginTransaction();

            $this->getAdapter()->getDriver()->getConnection()->commit();
            return array('status' => 1, 'message' => 'record is updated correctly');
        } catch (\Exception $exc) {
            $this->getAdapter()->getDriver()->getConnection()->rollback();
            return array('status' => -1);
        }
    }
}
