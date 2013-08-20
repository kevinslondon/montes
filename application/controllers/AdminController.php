<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('admin');
    }

    /**
     * Shows the list of pages to edit
     */
    public function indexAction()
    {
        if (!$this->logged_in()) {
            $this->_redirect('/admin/login');
            return;
        }

        $this->pagesAction();
    }

    /**
     * Show list of pages
     */
    public function pagesAction()
    {
        if (!$this->logged_in()) {
            $this->_redirect('/admin/login');
            return;
        }
        $content_mapper = new Application_Model_ContentMapper();
        $this->view->orders = $content_mapper->getSortOrderArray();

    }

    public function moveAction()
    {
        if (!$this->logged_in()) {
            $this->_redirect('/admin/login');
            return;
        }
        $request = $this->getRequest();
        $content_mapper = new Application_Model_ContentMapper();
        $current_order = $request->getParam('current_order');
        $new_order = $request->getParam('new_order');
        $content_mapper->swapPage($new_order, $current_order);
        $this->_redirect('/admin/pages');
    }

    /**
     * Edit or insert an existing page
     */
    public function editAction()
    {
        $form = new Application_Form_Edit();
        $request = $this->getRequest();
        $this->view->update_message = '';
        $content = new Application_Model_Content();
        if ($request->isPost() && $form->isValid($request->getParams())) {
            $content->populate($request->getParams());
            // print_r(get_object_vars($content));
            $content_mapper = new Application_Model_ContentMapper();
            $content_mapper->save($content);
            $this->view->update_message = '<strong>' . $request->getParam('title') . ' </strong>saved';
            $form->setDefaults($request->getParams());
        }
        if (!$request->isPost() && $request->getParam('url')) {
            $content_mapper = new Application_Model_ContentMapper();
            $url = $request->getParam('url');
            $content_mapper->findByUrl($url, $content, true);
            $form->setDefaults($content->toArray());
        }

        $this->view->form = $form;
        $this->view->content = $content;

    }

    public function ideleteAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('contentid') && $request->getParam('mediaid')) {
            $cm = new Application_Model_ContentMediaMapper();
            $m = new Application_Model_ContentMedia();
            $m->setContentid($request->getParam('contentid'))
                ->setMediaid($request->getParam('mediaid'));
            $cm->media_delete($m);
        }
        $this->_redirect('/admin/edit?url=' . $request->getParam('url'));
    }

    public function ipdeleteAction()
    {
        $request = $this->getRequest();
        if ($request->getParam('id')) {
            $m = new Application_Model_Media();
            $mapper = new Application_Model_MediaMapper();
            $mapper->find($request->getParam('id'), $m);
            $mapper->delete_image_from_disk($m);
            $mapper->delete($m);
        }
        $this->_redirect('/admin/images');
    }

    /**
     * Delete an existing page
     */
    public function deleteAction()
    {
        $request = $this->getRequest();

        $content_mapper = new Application_Model_ContentMapper();
        $url = $request->getParam('url');
        if ($url) {
            $content = new Application_Model_Content();
            $content_mapper->findByUrl($url, $content);
            $content_mapper->delete($content);
        }

        $this->_redirect('/admin/pages');
    }


    /**
     * Show a list of library images and create an upload form for images
     */
    public function imagesAction()
    {
        if (!$this->logged_in()) {
            $this->_redirect('/admin/login');
            return;
        }

        $media_mapper = new Application_Model_MediaMapper();
        $form = new Application_Form_Photos();
        $request = $this->getRequest();
        if ($form->isValid($request->getParams()) && $form->getElement('photo')->isUploaded()) {
            $this->handle_image_upload($form, $request, $media_mapper);
        }

        $this->view->images = $media_mapper->fetchAllLatestFirst();
        $this->view->form = $form;
    }

    public function imagegalleryAction()
    {
        if (!$this->logged_in()) {
            $this->_redirect('/admin/login');
            return;
        }
        $media_mapper = new Application_Model_MediaMapper();
        $this->view->images = $media_mapper->fetchAll();
        $this->view->url = $this->getRequest()->getParam('url');

    }

    public function addimageAction()
    {
        if (!$this->logged_in()) {
            $this->_redirect('/admin/login');
            return;
        }
        $request = $this->getRequest();
        $content_mapper = new Application_Model_ContentMapper();
        $url = $request->getParam('url');
        $content = new Application_Model_Content();
        $content_mapper->findByUrl($url, $content);
        $mapper = new Application_Model_ContentMediaMapper();
        $m = new Application_Model_ContentMedia();
        $m->setMediaid($request->getParam('id'));
        $m->setContentid($content->getId());
        $mapper->save($m);

        $this->_redirect('/admin/edit?url=' . $url);
    }

    /**
     * Handle the image upload
     * @param Application_Form_Photos $form
     * @param Zend_Controller_Request_Abstract $request
     * @param Application_Model_MediaMapper $media_mapper
     */
    private function handle_image_upload(Application_Form_Photos $form, Zend_Controller_Request_Abstract $request, Application_Model_MediaMapper $media_mapper)
    {
        $extension = pathinfo($form->getElement('photo')->getValue(), PATHINFO_EXTENSION);
        $media_model = new Application_Model_Media();
        $media_model->setName($request->getParam('name'))
            ->setThumb('')
            ->setWeb('')
            ->setOriginal('');

        $media_mapper->save($media_model);
        $form->getElement('photo')->addFilter('Rename', array(
            'target' => $media_model->getId() . '.' . $extension,
            'overwrite' => true
        ));

        $photo_type = $form->getElement('photo_type')->getValue();
        if($photo_type == 'page'){
            //Add the filter to resize to web image
            $form->getElement('photo')->addFilter(new Filters_File_Resize(array(
                'width' => 800,
                'height' => 600,
                'keepRatio' => true,
                'directory' => Zend_Registry::get('config')->paths->images->web
            )));
        }

        if($photo_type == 'workshop'){
            //Add the filter to resize to web image keeping the width to 680
            $form->getElement('photo')->addFilter(new Filters_File_Workshop(array(
                'width' => 680,
                'height' => 0,
                'keepRatio' => true,
                'directory' => Zend_Registry::get('config')->paths->images->web
            )));
        }



        //Add the filter to resize to thumb, note it can't be the same filter as above or the web image action will fail
        $form->getElement('photo')->addFilter(new Filters_File_Thumb(array(
            'width' => 200,
            'height' => 133,
            'keepRatio' => true,
            'directory' => Zend_Registry::get('config')->paths->images->thumbs
        )));


        if ($form->getElement('photo')->receive()) {
            $media_model->setThumb('photos/thumbs/' . $media_model->getId() . '.' . $extension);
            $media_model->setWeb('photos/web/' . $media_model->getId() . '.' . $extension);
            $media_model->setOriginal('photos/original/' . $media_model->getId() . '.' . $extension);
            $media_model->setMediaType($photo_type);
            $media_mapper->save($media_model);
        }
    }


    public function forgotAction()
    {
        $request = $this->getRequest();
        $form = new Application_Form_Forgot();
        $this->view->form = $form;
    }

    /**
     * Login using Zend_Auth
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $form = new Application_Form_Login();
        $result = -100;
        if ($request->isPost() && $form->isValid($request->getPost())) {
            $result = $this->login($request->getPost());
            if ($result == Zend_Auth_Result::SUCCESS) {
                $this->_redirect('/admin/pages');
                return;
            }
        }

        $this->view->loggin_result = $result;
        $this->view->form = $form;
    }

    private function login($post)
    {
        $adapter = $this->getLoginAuthAdapter();
        $adapter->setIdentity($post['email'])
            ->setCredential($post['pass']);

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        if (!$result->isValid()) {
            return $result->getCode();
        }

        $admin_user = $adapter->getResultRowObject();
        $auth->getStorage()->write($admin_user);
        return Zend_Auth_Result::SUCCESS;
    }

    private function getLoginAuthAdapter()
    {
        $db_adapter = Zend_Db_Table::getDefaultAdapter();
        $adapter = new Zend_Auth_Adapter_DbTable($db_adapter);
        $adapter->setTableName('admin')
            ->setIdentityColumn('email')
            ->setCredentialColumn('pass')
            ->setCredentialTreatment('MD5(?)');
        return $adapter;
    }

    private function logged_in()
    {
        $auth = Zend_Auth::getInstance();
        $user = $auth->getStorage()->read();
        return isset($user->email) && !empty($user->email);
    }


}

