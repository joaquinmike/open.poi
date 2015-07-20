<?php

/**
 * Description of AuthRecurso
 *
 * @author joaquinmike
 */

namespace Auth\Entity;

class AuthRecurso {
    
    const TIPO_MENU = 1;
    const TIPO_RECURSO = 2;
    
    const ESTADO_PERMISO = 'allow';
    
    const ROL_ADMIN = 1;
    const ROL_INVITADO = 2;
    
    /**
     * 
     * @param type $data
     */
    static function getConvertRecursoToMenu($data){
        $recursoId = NULL; $result = array();
        foreach ($data as $value){
            if(empty($value['rec_rec_id'])){
                $result[$value['rec_id']] = $value;
            }else{
                $value['rec_link'] = str_replace(':', '/', $value['rec_uri']);
                $result[$value['rec_rec_id']]['submenu'][$value['rec_id']] = $value;
            }
        }
        return $result;
    }
    
}
