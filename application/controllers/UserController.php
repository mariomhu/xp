<?php

class UserController extends Zend_Controller_Action {
	
	public function indexAction() {
	
	}
	
	public function registerAction() {

		
		if(Application_Model_Auth::getUser()) Application_Model_Auth::redirect();
		
		if($_POST){
			
			if(Application_Model_UserManager::get(array("email = ?" => $_POST['email']))){
				
				$this->view->error = "This email is already registered.";
				
			}elseif(Application_Model_UserManager::getByLogin($_POST['login'])){
				
				$this->view->error = "This login is already registered.";
				
			}else if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				
				Application_Model_UserManager::add($_POST);
				$id = Zend_Db_Table::getDefaultAdapter()->lastInsertId();
				$user = Application_Model_UserManager::get($id);
				Application_Model_Auth::login($user);
				$this->_helper->redirector("profile", "user");
				
			}
			
		}
	}
	
	public function profileAction() {
		$login = $this->getParam("login");
		if(!$login){
			Application_Model_Auth::checkIsUser();
			$user = Application_Model_Auth::getUser();
			$login = $user["login"];
		}
		
		$user = Application_Model_UserManager::getByLogin($login);
		
	}
	
}
