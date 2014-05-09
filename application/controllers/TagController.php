<?php

class TagController extends Zend_Controller_Action {


	public function indexAction() {
	
	}
	
	public function listAction() {

		$this->view->users = Application_Model_UserManager::getAll(null, 'name');
		
	}

	public function registerAction() {
		//Application_Model_Auth::checkIsAdmin();
		if($_POST){
			if(Application_Model_UserManager::get(array("name = ?" => $_POST['name']))){
				$this->view->error = "This tag is already registered.";
			}else{
				Application_Model_UserManager::add($_POST);
				$this->view->success = "Tag successfully created.";	
			}
		}
	}
	
	public function editAction() {
	
		Application_Model_Auth::checkIsUser();
		if($this->getParam('id')){
			Application_Model_Auth::checkIsAdmin();
			$id = $this->getParam('id');
			$admin = true;
		}else{
			$id = Application_Model_Auth::getUserId();
		}
		
		$user = Application_Model_UserManager::get($id);
		
		if($_POST){
				
			if(Application_Model_UserManager::get(array("email = ?" => $_POST['email'], "id != ?" => $id))){
	
				$this->view->error = "This email is already registered.";
	
			}else if(!$admin && md5($_POST['current-password']) != $user['password']){
	
				$this->view->error = "Password incorrect.";
	
			}else if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				
				if(!$_POST['password']) unset($_POST['password']);
				else $_POST['password'] = md5($_POST['password']);
				
				Application_Model_UserManager::set($_POST, $id);
				$user = Application_Model_UserManager::get($id);
				if(!$admin) Application_Model_Auth::login($user);
				
				$this->view->success = "Account successfully changed.";
	
			}
				
		}else{
			$_POST = $user;
		}
	}
	
	public function removeAction(){
		
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		Application_Model_Auth::checkIsAdmin();
		$id = $this->getParam('id');
		Application_Model_UserManager::remove($id);
		$this->_helper->redirector('index', 'user');
		
	}
	
}
