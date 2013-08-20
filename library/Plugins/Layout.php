<?php
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 11/05/12
 */
class Plugins_Layout extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $layout = Zend_Layout::getMvcInstance();
        $view = $layout->getView();

        $content_mapper = new Application_Model_ContentMapper();
		$view->browser_sniffer = new Plugins_Browser();

		try{
        	$view->menu = $content_mapper->getMenu($this->getLanguage());
		} catch(Zend_Session_Exception $e ) {
		
		} 
    }

    private function getLanguage()
    {
        $session = new Zend_Session_Namespace();

        if (isset($session->language)) {
            $session->language;
        } else {
            $session->language = 'en';
        }

        if($this->getRequest()->getParam('lang')){
            $session->language = $this->getRequest()->getParam('lang');
        }
        return $session->language;
    }
}
