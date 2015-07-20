<?php

/**
 * Currency db AuthRol
 *
 * @author joaquinmike
 */

namespace Auth\Model;

use Util\Model\Repository\Base\AbstractRepository;


class AuthRol extends AbstractRepository {

    /**
     * @var String Name of db table
     */
    protected $_table = 'auth_rol';

    /**
     * @var Adapter Db
     */
    public $adapter = null;

    /**
     * @var string or array of fields in table
     */
    protected $_primary = 'rol_id';
    
}