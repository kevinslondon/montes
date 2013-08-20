<?php
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 11/05/12
 */
class Module_Montes_Layout extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $layout = Zend_Layout::getMvcInstance();
        $view = $layout->getView();

        $content_mapper = new Application_Model_ContentMapper();

        $view->menu = $content_mapper->getMenu();
    }
}

