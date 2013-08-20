<?php

/**
 * Controller for displaying dynamic js pages
 */
class JsController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('js');
    }

    public function indexAction()
    {
        // action body
    }

    /**
     * Show the list of images as JS array
     */
    public function imagesAction()
    {
        $media_mapper = new Application_Model_MediaMapper();
        $this->view->images = $media_mapper->getTinyMCEImageList();

    }


}

