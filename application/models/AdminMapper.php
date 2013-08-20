<?php

class Application_Model_AdminMapper extends Application_Model_AbstractMapper
{

    function __construct()
    {
        $this->setDbTable('Application_Model_DbTable_Admin');
    }


    public function getLogin($email){
        $select = $this->getDbTable()->select()->where("email = '$email' ");
        $result = $this->getDbTable()->fetchRow($select);
        if (count($result) ==0 ) {
            return null;
        }

        $admin = new Application_Model_Admin();
        $admin->setEmail($result->email)
            ->setId($result->id)
            ->setPass($result->pass)
            ->setResetToken($result->reset_token)
            ->setResetValid($result->reset_valid);
        return $admin;

    }

    public function setResetToken(Application_Model_Admin $admin)
    {

    }


}

