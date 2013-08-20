<?php

class Application_Model_ContentMedia implements Application_Model_ModelInterface
{

    private $contentid;
    private $mediaid;

    function setId($id)
    {
        $this->contentid = $id;
        return $this;
    }

    function getId()
    {
        return $this->contentid;
    }


    public function setContentid($contentid)
    {
        $this->contentid = $contentid;
        return $this;
    }

    public function getContentid()
    {
        return $this->contentid;
    }

    public function setMediaid($mediaid)
    {
        $this->mediaid = $mediaid;
        return $this;
    }

    public function getMediaid()
    {
        return $this->mediaid;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }



}

