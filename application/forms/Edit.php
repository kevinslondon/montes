<?php

class Application_Form_Edit extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');

        $decorator = new Decorators_Inputs();


        // Add a title element
        $this->addElement('text', 'title', array(
            'label' => 'Menu title:',
            'sub_label' => '(English)',
            'required' => true,
            'style' =>'width:200px;',
            'filters' => array('StringTrim'),
            'validators' => array(
                'NotEmpty',
            ),
            'help' =>'',
            'decorators' => array($decorator)
        ));

        // Add a title element
        $this->addElement('text', 'title_es', array(
            'label' => 'Menu title:',
            'sub_label' => '(Spanish)',
            'required' => true,
            'style' =>'width:200px;',
            'filters' => array('StringTrim'),
            'validators' => array(
                'NotEmpty',
            ),
            'help' =>'',
            'decorators' => array($decorator)
        ));

        $this->addElement('text', 'url', array(
            'label' => 'Page address:',
            'sub_label' => '(no spaces, just lower case letters)',
            'style' =>'width:200px;',
            'required' => false,
            'filters' => array('StringTrim'),
            'validators' => array(
                'NotEmpty',
            ),
            'decorators' => array($decorator)

        ));

        $this->addElement('text', 'meta_keywords', array(
            'label' => 'Key words:',
            'sub_label' => '(key words separated by commas)',
            'style' =>'width:200px;',
            'required' => false,
            'filters' => array('StringTrim'),
            'validators' => array(
                'NotEmpty',
            ),
            'decorators' => array($decorator)

        ));

        $this->addElement('text', 'meta_keywords_es', array(
            'label' => 'Key words:',
            'sub_label' => '(Spanish key words separated by commas)',
            'style' =>'width:200px;',
            'required' => false,
            'filters' => array('StringTrim'),
            'validators' => array(
                'NotEmpty',
            ),
            'decorators' => array($decorator)

        ));

        $this->addElement('text', 'meta_description', array(
            'label' => 'Description:',
            'sub_label' => '(key word description)',
            'style' =>'width:200px;',
            'required' => false,
            'filters' => array('StringTrim'),
            'validators' => array(
                'NotEmpty',
            ),
            'decorators' => array($decorator)

        ));

        $this->addElement('text', 'meta_description_es', array(
        'label' => 'Description:',
        'sub_label' => '(Spanish key word description)',
            'style' =>'width:200px;',
            'required' => false,
            'filters' => array('StringTrim'),
            'validators' => array(
                'NotEmpty',
            ),
            'decorators' => array($decorator)

        ));


        // Add the English text
        $this->addElement('textarea', 'content_text', array(
            'label' => 'English Content:',
            'rows' => 25,
            'cols' => 70,
            'class' => 'tinymce',
            'required' => true,
            'validators' => array(
                'NotEmpty',
            ),
            'decorators' => array(new Decorators_Text())
        ));

        // Add the English text
        $this->addElement('textarea', 'content_text_es', array(
            'label' => 'Spanish Content:',
            'rows' => 25,
            'cols' => 70,
            'class' => 'tinymce',
            'required' => true,
            'validators' => array(
                'NotEmpty',
            ),
            'decorators' => array(new Decorators_Text())
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

        $this->addElement('hidden', 'id', array(
            'decorators' => array(new Decorators_Hidden())
        ));

        $this->addElement('hidden', 'order', array(
            'decorators' => array(new Decorators_Hidden())
        ));
    }


}

