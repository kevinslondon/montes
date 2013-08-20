<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    /*protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $content_mapper = new Application_Model_ContentMapper();

        $view->menu = $content_mapper->getMenu();
    }*/

    protected function _initConfig()
    {
		Zend_Session::start();
        //Grabs the values for application.ini
        $config = new Zend_Config($this->getOptions(), true);
        Zend_Registry::set('config', $config);
        return $config;
    }


    protected function _initRoutes() {
        error_reporting(E_ALL|E_STRICT);
        ini_set('display_errors', 'on');


        $frontController = Zend_Controller_Front::getInstance();
        $router = $frontController->getRouter();

        $admin = new Zend_Controller_Router_Route('admin',array('controller'=>'Admin', 'action'=>'index'));
       // $login = new Zend_Controller_Router_Route('admin/login',array('controller'=>'Admin', 'action'=>'login'));
        $contact = new Zend_Controller_Router_Route('contact',array('controller'=>'Form', 'action'=>'contact'));

        $route_content = new Zend_Controller_Router_Route_Regex(
            '(\w*)',
            array('controller' => 'content',
                'action' => 'index' ),
            array(1 => 'url')
        );

        try{
            $router->addRoute('content', $route_content);
            $router->addRoute('form', $contact);
          //  $router->addRoute('form', $login);
            $router->addRoute('admin', $admin);
        }catch(Exception $e) {
            print($e->getTraceAsString());
        }

       Zend_Controller_Front::getInstance()->registerPlugin(new Plugins_Layout());
    }


}

