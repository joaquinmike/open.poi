<?php

namespace Util\Form;

use Zend\Form\Form;

class BaseForm extends Form {

    protected $_name;
    protected $_rawElements = array();

    public function __construct($name = null) {
        parent::__construct($name);
    }

    public function isValid($request = null) {
        $this->__addValidator();
        if ($request->isPost()) {
            $query = $request->getQuery();
            $query = is_object($query) ? $query->toArray() : $query;
            $post = $request->getPost();
            foreach ($post as $var => $value) {
                $query[$var] = $value;
            }
            $this->setData($query);
            $valid = parent::isValid();
            //$this->setMessages($this->getMessages());
            return $valid; 
        } else {
            return false;
        }
    }

    public function add($elementOrFieldset, array $flags = array()) {
        $form = parent::add($elementOrFieldset, $flags);
        $this->_rawElements[] = $elementOrFieldset;
        return $form;
    }

    private function __addValidator() {
        $this->setInputFilter(new BaseFormValidator($this->_rawElements));
    }

}
