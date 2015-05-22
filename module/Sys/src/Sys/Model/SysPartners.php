<?php
namespace Sys\Model;

use Util\Model\Repository\Base\AbstractRepository;

class SysPartners extends AbstractRepository {

    /**
     * @var String Name of db table
     */
    protected $_table = 'sys_partners';

    /**
     * @var string or array of fields in table
     */
    protected $_primary = 'partner_id';

    

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
    
    /**
     * 
     * @param type $key
     */
    public function getParterKey($key){
        return $this->getBy(array('partner_key=?' => $key), TRUE);
    }
}
