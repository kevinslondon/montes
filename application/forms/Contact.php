<?php

class Application_Form_Contact extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');

        $decorator = new Decorators_Inputs();


        // Add a name element
        $this->addElement('text', 'name', array(
            'label' => 'Your name:',
            'required' => true,
            'style' =>'width:200px;',
            'filters' => array('StringTrim'),
            'validators' => array(
                'NotEmpty',
            ),
            'decorators' => array($decorator)
        ));

        $this->addElement('text', 'phone', array(
            'label' => 'Your phone:',
            'style' =>'width:200px;',
            'required' => false,
            'filters' => array('StringTrim'),
            'decorators' => array($decorator)

        ));

        // Add an email element
        $this->addElement('text', 'email', array(
            'label' => 'Email address:',
            'style' =>'width:200px;',
            'required' => true,
            'filters' => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            ),
            'decorators' => array($decorator)
        ));

        // Add the comment element
        $this->addElement('textarea', 'comment', array(
            'label' => 'Your Question:',
            'rows' => 5,
            'cols' => 70,
            'required' => true,
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 1000))
            ),
            'decorators' => array(new Decorators_Text())
        ));

        // Add a captcha
       /* $this->addElement('captcha', 'captcha', array(
            'label' => 'Please enter the 5 letters displayed below:',
            'required' => true,
            'captcha' => array(
                'captcha' => 'Image',
                'wordLen' => 5,
                'timeout' => 300,
                'height' => 50,
                'font' => 'C:/Windows/Fonts/arial.ttf'// APPLICATION_PATH.'/public/css/arial.ttf'
            )
        ));*/

        //echo APPLICATION_PATH.'/public/css/calibri.ttf'; die();

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

