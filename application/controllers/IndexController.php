<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	set_time_limit(0);
        $gps = new Application_Model_DbTable_GPS();
        $this->view->GPS = $gps->fetchSome(20);
    }
    
    public function getusernearbyresultAction()
    {
    	$max = $this->_getParam('max', 0);
    	$latitude = $this->_getParam('latitude', 0);
    	$longtitude = $this->_getParam('longtitude', 0);
    	$gps = new Application_Model_DbTable_GPS();
    	$this->view->GPS = $gps->getUserNearby($max,$latitude,$longtitude);
    }
    
    public function getusernearbyAction()
    {
    	$form = new Application_Form_usernearby();
    	$form->submit->setLabel('Find Users');
    	$this->view->form = $form;
    	
    	if ($this->getRequest()->isPost()) {
    		$formData = $this->getRequest()->getPost();
    		if ($form->isValid($formData)) {
    			$latitude = $form->getValue('latitude');;
    			$longtitude = $form->getValue('longtitude');
    			$max = $form->getValue('max');
    			
    			$gps = new Application_Model_DbTable_GPS();
    			$gps->getUserNearby($latitude, $longtitude,$max);  
    			$params = array('max' => $max);
    			$this->_helper->redirector('getusernearbyresult','index','default',$params);
    		} else {
    			$form->populate($formData);
    		}
    	}
    }
    
    public function addAction()
    {
    	$form = new Application_Form_GPS();
    	$form->submit->setLabel('Add');
    	$this->view->form = $form;
    
    	if ($this->getRequest()->isPost()) {
    		$formData = $this->getRequest()->getPost();
    		if ($form->isValid($formData)) {    		
    			$id = $form->getValue('id');;
    			$nickname = $form->getValue('nickname');
    			$age = $form->getValue('age');
    			$latitude = $form->getValue('latitude');
    			$longtitude = $form->getValue('longtitude');
    			$gps = new Application_Model_DbTable_GPS();
    			$gps->addUser($id, $nickname,$age,$latitude,$longtitude);
    
    			$this->_helper->redirector('index');
    		} else {
    			$form->populate($formData);
    		}
    	}
    
    }   
 
    public function addallAction()
    {
    	$gps = new Application_Model_DbTable_GPS();
    	$gps->clearalltable();
    	set_time_limit(0);
    	for ($i = 1; $i <= 10000; $i++)
    	{
    		$id = $i;
    		$nickname = $i . "ABCDEF";
    		$age = rand(10,60);
    		$latitude = (rand(0,90)*pi())/180;
    		$longtitude = (rand(0,90)*pi())/180;    		
    		$gps->addUser($id, $nickname,$age,$latitude,$longtitude);    		   		
		}
		
		$this->_helper->redirector('index');
    }

    public function editAction()
    {
        $form = new Application_Form_GPS();
        $form->submit->setLabel('Save');
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('id');
                $nickname = $form->getValue('nickname');
                $age = (int)$form->getValue('age');
                $latitude = (int)$form->getValue('latitude');
                $longtitude = (int)$form->getValue('longtitude');
                $gps = new Application_Model_DbTable_GPS();
                $gps->updateUser($id, $nickname, $age, $latitude, $longtitude);            
                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        } else {
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                $gps = new Application_Model_DbTable_GPS();
                $form->populate($gps->getUser($id));
            }
        }        
    }

    public function deleteAction()
    {
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Yes') {
                $id = $this->getRequest()->getPost('id');
                $gps = new Application_Model_DbTable_GPS();
                $gps->deleteUser($id);
            }
            $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id', 0);
            $gps = new Application_Model_DbTable_GPS();
            $this->view->GPS = $gps->getUser($id);
        }
    }


}







