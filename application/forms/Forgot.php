<?php

class Application_Form_Forgot extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');

        $decorator = new Decorators_Inputs();

        // Add a name element
        $this->addElement('text', 'email', array(
            'label' => 'Your email:',
            'required' => true,
            'style' =>'width:200px;',
            'filters' => array('StringTrim'),
            'validators' => array(
                'NotEmpty'
            ),
            'decorators' => array($decorator)
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'value' => 'Submit',
            'decorators' => array(new Decorators_Submit())
        ));

        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
            'decorators' => array(new Decorators_Hidden())
        ));
    }


}

