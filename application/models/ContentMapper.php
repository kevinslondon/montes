<?php

class Application_Model_ContentMapper extends Application_Model_AbstractMapper
{
    function __construct()
    {
        $this->setDbTable('Application_Model_DbTable_Content');
    }


    public function save(Application_Model_Content $content,$set_update_date=true)
    {
        $data = $content->toArray();
        if(!$data){
            return;
        }
        if($set_update_date){
            $data['update_date'] = date('Y-m-d H:i:s');
        }
        foreach($data as &$d){
            stripslashes($d);
        }

        if (!$content->getId()) {
            unset($data['id']);
            $data['order'] = $this->getNextSortOrder();
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('`id` = ?' => $content->getId()));
        }
    }


    public function getMenu($language='en')
    {
        $menu = array();

        $entries = $this->fetchAll();
        foreach ($entries as $c) {
            /**
             * @var $c Application_Model_Content
             */
            $url = $c->getUrl() ? $c->getUrl() : $c->getId();
            $menu[$url] = $language=='en' ? $c->getTitle() : $c->getTitleEs();
        }


        return $menu;

    }

    public function find($id, Application_Model_Content $content)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $this->setContent($result->current(), $content);
    }

    public function findByOrder($order, Application_Model_Content $content)
    {
        $select = $this->getDbTable()->select()->where(" `order` = $order ");
        $result = $this->getDbTable()->fetchRow($select);
        if (0 == count($result)) {
            return;
        }
        $this->setContent($result, $content);
    }

    /**
     * Get the content
     * @param $url
     * @param Application_Model_Content $content
     * @param bool $get_content_media, will get the content media
     */
    public function findByUrl($url, Application_Model_Content $content, $get_content_media = false)
    {
        if (!$url) {
            $url = 'home';
        }
        $select = $this->getDbTable()->select()->where(" `url` = '$url' ");
        $result = $this->getDbTable()->fetchRow($select);
        if (0 == count($result)) {
            return;
        }
        $this->setContent($result, $content);
        if ($get_content_media) {
            $media_mapper = new Application_Model_MediaMapper();
            $content->setMedia($media_mapper->getContentMedia($content->getId()));
        }
    }

    private function setContent($row, Application_Model_Content $content)
    {
        $content->populate($row);
    }

    public function fetchAll()
    {
        $select = $this->getDbTable()->select()->order("order ASC ");
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Content();
            $this->setContent($row, $entry);
            $entries[] = $entry;
        }
        return $entries;
    }

    public function swapPage($new_order, $old_order)
    {
        $page = new Application_Model_Content();
        $this->findByOrder($old_order, $page);
        $page->setOrder($new_order);

        $swap_page = new Application_Model_Content();
        $this->findByOrder($new_order, $swap_page);
        $swap_page->setOrder($old_order);


        if($page != null){
           $this->save($page);
        }

        if($swap_page != null){
           $this->save($swap_page);
        }

    }

    public function getSortOrderArray()
    {
        $this->resortPages();
        $result = array();
        $entries = $this->fetchAll();
        foreach ($entries as $c) {
            /**
             * @var $c Application_Model_Content
             */
            $result[] = $c->getOrder();
        }
        return $result;
    }

    private function resortPages()
    {
        $pages = $this->fetchAll();
        $counter = 1;
        foreach($pages as $page)
        {
            /**
             * @var Application_Model_Content $page
             */
            $page->setOrder($counter++);
            $this->save($page, false);

        }
    }

    private function getNextSortOrder()
    {
        $select = $this->getDbTable()->select()->order("order DESC ");
        $result = $this->getDbTable()->fetchRow($select);
        return $result['order'] + 1;
    }

}

