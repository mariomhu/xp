<?php
class TagController extends Zend_Controller_Action {
	public function indexAction() {
	}
	public function listAction() {
	}
	public function registerAction() {
<<<<<<< HEAD
		Application_Model_Auth::checkIsAdmin();
		if($_POST){
			if(Application_Model_TagManager::get(array("name = ?" => $_POST['name']))){
				$this->view->error = "This tag is already registered.";
			}else{
				Application_Model_TagManager::add($_POST);
				$this->view->success = "Tag successfully created.";	
=======
		// Application_Model_Auth::checkIsAdmin();
		if ($_POST) {
			if (Application_Model_UserManager::get ( array (
					"name = ?" => $_POST ['name'] 
			) )) {
				$this->view->error = "This tag is already registered.";
			} else {
				Application_Model_UserManager::add ( $_POST );
				$this->view->success = "Tag successfully created.";
>>>>>>> 0b9e90d04da4533f4ee5953a198b5567fa8cd41d
			}
		}
	}
	public function editAction() {
	}
	public function removeAction() {
	}
}
