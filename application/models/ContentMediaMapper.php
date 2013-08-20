<?php

class Application_Model_ContentMediaMapper extends Application_Model_AbstractMapper
{

    function __construct()
    {
        $this->setDbTable('Application_Model_DbTable_ContentMedia');
    }

    public function media_delete(Application_Model_ContentMedia $cm)
    {
        $this->getDbTable()->delete('contentid=' . $cm->getContentid() . ' AND mediaid=' . $cm->getMediaid());
    }

    public function save(Application_Model_ContentMedia $content)
    {
        $data = $content->toArray();
        $this->getDbTable()->insert($data);
    }


}

