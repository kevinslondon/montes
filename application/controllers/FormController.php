<?php

class FormController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     * Handle contact email
     */
    public function contactAction()
    {
        $request = $this->getRequest();
        $form = new Application_Form_Contact();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost()) && $this->send($this->getRequest())) {

                $this->_forward('thanks');
            }
        }

        $this->view->form = $form;
        $content_mapper = new Application_Model_ContentMapper();
        $content = new Application_Model_Content();
        $content_mapper->findByUrl('contact', $content,true);
        $this->view->content = $content;
    }


    /**
     * Show thanks message after the user has contacted the site
      */
    public function thanksAction()
    {
        // action body
    }

    /**
     * Send email to user and admin after contact form is filled in
     * @param Zend_Controller_Request_Abstract $request
     * @return bool
     */
    private function send(Zend_Controller_Request_Abstract $request)
    {

        $session = new Zend_Session_Namespace();

        if (isset($session->numberOfPageRequests)) {
            $session->numberOfPageRequests++;
        } else {
            $session->numberOfPageRequests = 1;
        }

        //pretend mail has been sent for people repeatedly hitting refresh
        if ($session->numberOfPageRequests > 2) {
            return true;
        }

        $email_mapper = new Application_Model_EmailMapper();
        $email = $email_mapper->getEmailByName('ContactAcknowledge', $request);

        $mail = new Zend_Mail();
        $mail->setBodyText($email->getText());
        $mail->setBodyHtml($email->getHtml());
        $mail->setFrom('admin@casamontesnegros.com', 'Rachael Saunders');
        $mail->addTo( $request->getParam('email'), $request->getParam('name'));
        $mail->setSubject('Thanks for contacting Casa Montes Negros');
        $mail->send();
		
		//Admin email
		//todo set up email names as constants
        $email = $email_mapper->getEmailByName('ContactEmail', $request);
		$mail = new Zend_Mail();
		$mail->setBodyText($email->getText());
        $mail->setBodyHtml($email->getHtml());
		$mail->setFrom('admin@casamontesnegros.com', 'Rachael Saunders');
        $mail->addTo( 'rachael1210@gmail.com', 'Rachael Saunders');
        $mail->setSubject('Casamontesnegros contact email');
        $mail->send();

        return true;

    }


}





