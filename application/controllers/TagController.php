<?php
class TagController extends Zend_Controller_Action {
	
	public function listAction() {
		Application_Model_Auth::checkIsAdmin();
		$this->view->tags = Application_Model_TagManager::getAll(null, 'name');
	}
	
	public function registerAction() {
		Application_Model_Auth::checkIsAdmin();
		if($_POST){
			if(Application_Model_TagManager::get(array("name = ?" => $_POST['name']))){
				$this->view->error = "This tag is already registered.";
			}else{
				Application_Model_TagManager::add($_POST);
				$this->view->success = "Tag successfully created.";
			}
		}
	}

	public function editAction() {
		Application_Model_Auth::checkIsAdmin();
		$id = $this->getParam("id");
		if($_POST){
			if(Application_Model_TagManager::get(array("name = ?" => $_POST['name'], "id != ?" => $id))){
				$this->view->error = "This name is already registered.";
			}else{
				Application_Model_TagManager::set($_POST, $id);
				$this->view->success = "This tag has been changed.";
			}
		}else{
			$_POST = Application_Model_TagManager::get($id);
		}
	}
	public function removeAction() {
		Application_Model_Auth::checkIsAdmin();
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$id = $this->getParam('id');
		Application_Model_TagManager::remove($id);
		$this->_helper->redirector('index', 'list', 'tag');
	}
}
	
	