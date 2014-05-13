<?php

class ProblemController extends Zend_Controller_Action {

	public function indexAction() {
	
	}
	
	public function registerAction() {
		//Application_Model_Auth::checkIsAdmin();
		
		if($_POST){
			Application_Model_ProblemManager::add($_POST);
			$id = Zend_Db_Table::getDefaultAdapter()->lastInsertId();
			move_uploaded_file($_FILES['description']['tmp_name'], "problems/".$id.".pdf");
			Zend_Debug::dump($_FILES['description']['tmp_name']);
			//$this->_helper->redirector->gotoUrl("/index.php/p/$id");
		}
	}
	
}
