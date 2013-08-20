<?php

class Application_Form_Photos extends Zend_Form
{

    public function init()
    {
        $decorator = new Decorators_Inputs();

        // Add a name element
        $this->addElement('text', 'name', array(
            'label' => 'Photo Name:',
            'required' => true,
            'style' => 'width:200px;',
            'filters' => array('StringTrim'),
            'validators' => array(
                'NotEmpty'
            ),
            'decorators' => array($decorator)
        ));


        $photo = new Zend_Form_Element_File('photo');
        $photo->setLabel('Photo (jpg only)')
            ->setDestination(Zend_Registry::get('config')->paths->images->original);
        // ensure only one file
        $photo->addValidator('Count', false, 1);
        // max 10MB
        $photo->addValidator('Size', false, 10097152)
            ->setMaxFileSize(10097152);
        // only JPEG, PNG, or GIF
        $photo->addValidator('Extension', false, 'jpg,png,gif');
        $photo->setValueDisabled(true);
        $photo->setDecorators(array('File', new Decorators_Files()));
        $this->addElement($photo, 'photo');


        $photo_type = new Zend_Form_Element_Radio('photo_type');
        $photo_type->setLabel('Photo Type:');
        $photo_type->addMultiOption(Application_Model_Media::MEDIA_TYPE_PAGE, 'Page');
        $photo_type->addMultiOption(Application_Model_Media::MEDIA_TYPE_WORKSHOP, 'Workshop');
        $photo_type->setAttrib('default_value', Application_Model_Media::MEDIA_TYPE_PAGE);
        $photo_type->setDecorators(array(new Decorators_Radio()));
        $photo_type->addValidator('NotEmpty');
        $this->addElement($photo_type, 'photo_type');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setValue('Upload');
        $submit->setName('Upload');
        $submit->setDecorators(array(new Decorators_Submit()));
        $this->addElement($submit);

    }


}

