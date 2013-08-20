<?php

class ContentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     * Show a dynamic content page
     */
    public function indexAction()
    {
        $url_redirect = $this->getRequest()->getParam('url_redirect');
        if ($url_redirect) {
            $this->_redirect($url_redirect);
            return;
        }

        // action body
        $content_mapper = new Application_Model_ContentMapper();

        $url = $this->getRequest()->getParam('url');
        $content = new Application_Model_Content();
        $content_mapper->findByUrl($url, $content, true);
        $this->view->content = $content;
        $this->view->content_text = $this->getContentText($content);
		

    }


    private function getContentText(Application_Model_Content $content)
    {
        return $this->getLanguage() == 'en' ? $content->getContentText() : $content->getContentTextEs();
    }

    private function getLanguage()
    {
        $session = new Zend_Session_Namespace();

        if (isset($session->language)) {
            return $session->language;
        } else {
            return $session->language = 'en';
        }

    }


}



