<?php

class Application_Model_Content extends Application_Model_AbstractModel implements Application_Model_ModelInterface
{
    protected  $id;
    protected $menu_id;
    protected $content_text;
    protected $meta_keywords;
    protected $meta_keywords_es;
    protected $meta_description;
    protected $meta_description_es;
    protected $content_text_es;
    protected $update_date;
    protected $url;
    protected $title;
    protected $title_es;
    protected $media;
    protected $order;

    function __construct()
    {

    }


    public function setContentText($content_text)
    {
        $this->content_text = stripslashes($content_text);
        return $this;
    }

    public function getContentText()
    {
        return $this->content_text;
    }

    public function setContentTextEs($content_text_es)
    {
        $this->content_text_es = $content_text_es;
        return $this;
    }

    public function getContentTextEs()
    {
        return $this->content_text_es;
    }

    public function setTitleEs($title_es)
    {
        $this->title_es = $title_es;
        return $this;
    }

    public function getTitleEs()
    {
        return $this->title_es;
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

    public function setMenuId($menu_id)
    {
        $this->menu_id = $menu_id;
        return $this;
    }

    public function getMenuId()
    {
        return $this->menu_id;
    }

    public function setUpdateDate($update_date)
    {
        $this->update_date = $update_date;
        return $this;
    }

    public function getUpdateDate()
    {
        return $this->update_date;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setTitle($title)
    {
        $this->title = stripslashes($title);
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setMedia($media)
    {
        $this->media = $media;
        return $this;
    }

    public function getMedia()
    {
        return $this->media;
    }

    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setMetaDescription($meta_description)
    {
        $this->meta_description = $meta_description;
        return $this;
    }

    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    public function setMetaDescriptionEs($meta_description_es)
    {
        $this->meta_description_es = $meta_description_es;
        return $this;
    }

    public function getMetaDescriptionEs()
    {
        return $this->meta_description_es;
    }

    public function setMetaKeywords($meta_keywords)
    {
        $this->meta_keywords = $meta_keywords;
        return $this;
    }

    public function getMetaKeywords()
    {
        return $this->meta_keywords;
    }

    public function setMetaKeywordsEs($meta_keywords_es)
    {
        $this->meta_keywords_es = $meta_keywords_es;
        return $this;
    }

    public function getMetaKeywordsEs()
    {
        return $this->meta_keywords_es;
    }



}

