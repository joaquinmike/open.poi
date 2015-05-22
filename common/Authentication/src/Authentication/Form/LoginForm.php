<?php
//filename : module/Authentication/src/Authentication/Form/LoginForm.php
namespace Authentication\Form;

use Util\Form;

class LoginForm extends Form\BaseForm
{
    public function __construct()
    {
        parent::__construct();

       $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'username',
            'required' => true,
            'attributes' => array(
                'id' => 'username',
                'class' => 'form-control',
            ),
            'validators' => array(array('name' => 'not_empty'),)
        ));
        

       $this->add(array(
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password',
            'required' => true,
            'attributes' => array(
                'id' => 'password',
                'class' => 'form-control',
            ),
            'validators' => array(array('name' => 'not_empty'),)
        ));
        
      
    }

   
}
