<?php

namespace Util\Form;

use Zend\InputFilter\InputFilter;

class BaseFormValidator extends InputFilter {

    public function __construct($elements) {
        if(!empty($elements)){
            foreach ($elements as $element){
                if(isset($element['validators'])){
                    $this->add(array(
                        'name' => $element['name'],
                        'validators' => $element['validators']
                        )
                    );
                }
            }
        }
    }
}
