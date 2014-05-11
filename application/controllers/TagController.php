<?php
class TagController extends Zend_Controller_Action {
	public function indexAction() {
	}
	public function listAction() {
	}
	public function registerAction() {
		// Application_Model_Auth::checkIsAdmin();
		if ($_POST) {
			if (Application_Model_UserManager::get ( array (
					"name = ?" => $_POST ['name'] 
			) )) {
				$this->view->error = "This tag is already registered.";
			} else {
				Application_Model_UserManager::add ( $_POST );
				$this->view->success = "Tag successfully created.";
			}
		}
	}
	public function editAction() {
	}
	public function removeAction() {
	}
}
