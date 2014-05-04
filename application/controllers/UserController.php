<?php

class UserController extends Zend_Controller_Action {


	public function indexAction() {
	
		$login = $this->getParam("login");
		if(!$login){
			Application_Model_Auth::checkIsUser();
			$user = Application_Model_Auth::getUser();
			$login = $user["login"];
		}
	
		$user = Application_Model_UserManager::getByLogin($login);
	
		$this->view->submissions = $user['ac']+ $user['pe'] + $user['wa'] + $user['ce'] + $user['re'] + $user['tl'];
		$this->view->user = $user;
	
	}
	
	public function listAction() {

		$this->view->users = Application_Model_UserManager::getAll(null, 'name');
		
	}

		public function registerAction() {
		
		if(Application_Model_Auth::getUser()) Application_Model_Auth::redirect();
		
		if($_POST){
			
			if(Application_Model_UserManager::get(array("email = ?" => $_POST['email']))){
				
				$this->view->error = "This email is already registered.";
				
			}elseif(Application_Model_UserManager::getByLogin($_POST['login'])){
				
				$this->view->error = "This login is already registered.";
				
			}else if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				
				$_POST['password'] = md5($_POST['password']);
				Application_Model_UserManager::add($_POST);
				$id = Zend_Db_Table::getDefaultAdapter()->lastInsertId();
				$user = Application_Model_UserManager::get($id);
				Application_Model_Auth::login($user);
				$this->view->success = "Account successfully created.";
				
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
