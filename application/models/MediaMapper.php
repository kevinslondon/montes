<?php

class Application_Model_MediaMapper extends Application_Model_AbstractMapper
{

    function __construct()
    {
        $this->setDbTable('Application_Model_DbTable_Media');
    }

    public function delete_image_from_disk(Application_Model_Media $media)
    {
        $root_path = realpath(dirname(__FILE__)) . '/../../public/';;
        if($media->getThumb()){
            unlink($root_path.$media->getThumb());
        }

        if($media->getWeb()){
            unlink($root_path.$media->getWeb());
        }

        if($media->getOriginal()){
            unlink($root_path.$media->getOriginal());
        }

    }


    public function save(Application_Model_Media $media)
    {
        $data = $media->toArray();

        if (!$media->getId()) {
            unset($data['id']);
            $id = $this->getDbTable()->insert($data);
            $media->setId($id);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $media->getId()));
        }
    }


    public function find($id, Application_Model_Media $media)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $media->populate($result->current());
    }

    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        return $this->mediaResults($resultSet);
    }

    public function getTinyMCEImageList()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        foreach ($resultSet as $row) {
            $media = new Application_Model_Media();
            $media->populate($row);
            //If the media type is workshop, we want to drop the web image into the page, not the thumb
            if($media->getMediaType() == Application_Model_Media::MEDIA_TYPE_WORKSHOP){
                $media->setThumb($media->getWeb());
            }
            $entries[] = $media;
        }
        return $entries;
    }

    public function fetchAllLatestFirst()
    {
        $select = $this->getDbTable()->select()->order("id DESC ");
        $resultSet = $this->getDbTable()->fetchAll($select);
        return $this->mediaResults($resultSet);

    }

    /**
     * @param $resultSet
     * @return array
     */
    private function mediaResults($resultSet)
    {
        $entries = array();
        foreach ($resultSet as $row) {
            $media = new Application_Model_Media();
            $media->populate($row);
            $entries[] = $media;
        }
        return $entries;
    }

    public function getContentMedia($content_id)
    {
        $select = $this->getDbTable()
            ->select()->setIntegrityCheck(false)->distinct()
            ->from(array('m'=>'media'),
            array('m.id', 'web', 'thumb', 'original')
        )
            ->join(array('cm' => 'content_media'), 'cm.mediaid = m.id')
            ->where('cm.contentid='.$content_id);

        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $media = new Application_Model_Media();
            $media->populate($row);
            $entries[] = $media;
        }
        return $entries;

    }


}

