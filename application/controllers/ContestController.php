<?php

class ContestController extends Zend_Controller_Action {

	public function indexAction() {
		$id = $this->getParam ( "id" );
		
		$problem = Application_Model_::get( $id );
		
		$this->view->submissions = $problem ['ac'] + $problem ['pe'] + $problem ['wa'] + $problem ['ce'] + $problem ['re'] + $problem ['tl'];
		$this->view->problem = $problem;
		
		$this->view->tags = Application_Model_TagManager::getByProblem($id);
		
	
	}
	
	public function registerAction() {
		//Application_Model_Auth::checkIsAdmin ();
		if ($_POST) {
				
			$_POST ['id'] = array_flip ( explode ( ',', $_POST ['id'] ) );
			$user = Application_Model_Auth::getUser();
			$_POST ['admin'] = $user['id'];
									
			Application_Model_ContestManager::add ( $_POST );
			$id = Zend_Db_Table::getDefaultAdapter ()->lastInsertId ();
										
			$this->view->id = $id;
			$this->view->success = "Contest successfully created.";
		}		
	}
	
	public function editAction() {
	
	}
	
	public function listAction() {
	
	}
	
	public function removeAction() {
	
	}
}
