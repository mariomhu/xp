<?php
class IndexController extends Zend_Controller_Action {
	
	
	public function indexAction() {
		$tag = intval ( $this->getParam ( "tag" ) );
		if ($tag) {
			$this->view->problems = Application_Model_ProblemManager::getByTag($tag);
			$tag = Application_Model_TagManager::get ( $tag );
			$this->view->title = "Problems - $tag[name]";
		} else {
			$this->view->title = "All Problem";
			$this->view->problems = Application_Model_ProblemManager::getLast ();
		}
		//List Last 10 Users
		$this->view->users = Application_Model_UserManager::getlast();
		//List Last 10 Users
		$this->view->submissions = Application_Model_SubmissionManager::getLast();
		
		$this->view->bestsubmissions = Application_Model_BestSubmissionManager::getBest();
	}
		//$this->_helper->redirector('login', 'index');

	
	public function contactAction() {
	}
	
	public function aboutAction() {
	}
	
	public function loginAction() {
		$this->_helper->layout()->disableLayout();
		if($_POST){
			$password = md5($_POST['password']);
			$user = Application_Model_UserManager::get(array('login = ?' => $_POST['username'], 'password = ?' => $password));
			if(!$user) $user = Application_Model_UserManager::get(array('email = ?' => $_POST['username'], 'password = ?' => $password));
			if(!$user){
				sleep(2);
			}else{
				Application_Model_Auth::login($user);
				$this->_helper->redirector('index', 'user');
			}
		}
	}
	
	public function logoutAction() {
		$this->_helper->layout()->disableLayout();
		Application_Model_Auth::logout();
		Application_Model_Auth::redirect();
	}
	
}

