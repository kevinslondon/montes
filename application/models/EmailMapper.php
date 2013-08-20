<?php

class Application_Model_EmailMapper extends Application_Model_AbstractMapper
{

    function __construct(){
        $this->setDbTable('Application_Model_DbTable_Email');
    }

    public function save(Application_Model_Email $email)
    {
        $data = array(
            'id' => $email->getId(),
            'name' => $email->getName(),
            'placeholders' => $email->getPlaceholders(),
            'subject' => $email->getSubject(),
            'html' => $email->getHtml(),
            'text'   => $email->getText(),
            'notes' => $email->getNotes(),

        );

        if (null === ($id = $email->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }


    public function getEmailByName($email_name, Zend_Controller_Request_Http $request = null)
    {
        $select = $this->getDbTable()->select()->where("name = '$email_name' ");
        $result = $this->getDbTable()->fetchRow($select);
        if (count($result) ==0 ) {
            return null;
        }
        $email =  new Application_Model_Email();
        $this->setEmail($result->toArray(),$email);
        $this->setText($email, $request);
        return $email;
    }

    private function setEmail($row, Application_Model_Email $email)
    {
        $email->setId($row['id'])
            ->setName($row['name'])
            ->setPlaceholders($row['placeholders'])
            ->setSubject($row['subject'])
            ->setHtml($row['html'])
            ->setText($row['text'])
            ->setNotes($row['notes'])
        ;
    }

    private function setText(Application_Model_Email $email,Zend_Controller_Request_Http $request ){
        if($request == null) {
            return;
        }
        $html = $email->getHtml();
        $text = $email->getText();
        $post = $request->getPost();
        foreach($post as $field => $value) {
            $html = str_replace('%'.$field.'%',$value, $html);
            $text = str_replace('%'.$field.'%',$value, $text);
        }
        $email->setHtml($html);
        $email->setText($text);
    }
}

