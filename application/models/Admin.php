<?php

class Application_Model_Admin  implements Application_Model_ModelInterface
{
    private $id;
    private $email;
    private $pass;
    private $reset_token;
    private $reset_valid;

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setPass($pass)
    {
        $this->pass = $pass;
        return $this;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function setResetToken($reset_token)
    {
        $this->reset_token = $reset_token;
        return $this;
    }

    public function getResetToken()
    {
        return $this->reset_token;
    }

    public function setResetValid($reset_valid)
    {
        $this->reset_valid = $reset_valid;
        return $this;
    }

    public function getResetValid()
    {
        return $this->reset_valid;
    }






}

