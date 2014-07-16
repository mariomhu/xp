<?php

class ContestController extends Zend_Controller_Action {

	public function indexAction() {
// 		$id = $this->getParam ( "id" );
		
// 		$problem = Application_Model_::get( $id );
		
// 		$this->view->submissions = $problem ['ac'] + $problem ['pe'] + $problem ['wa'] + $problem ['ce'] + $problem ['re'] + $problem ['tl'];
// 		$this->view->problem = $problem;
		
// 		$this->view->tags = Application_Model_TagManager::getByProblem($id);
		
		$this->view->contests = Application_Model_ContestManager::getContests();
		
		$this->view->problems = Application_Model_ProblemManager::getAll ();
	}
	
	public function registerAction() {
		//Application_Model_Auth::checkIsAdmin ();
		$this->view->users = Application_Model_UserManager::getAll(null, name);
		
		$this->view->problems = Application_Model_ProblemManager::getAll(null, title);
		
		if ($_POST) {
			
			$_POST ['users'] = array_flip ( explode ( ',', $_POST ['users'] ) );
			$_POST ['problems'] = array_flip ( explode ( ',', $_POST ['problems'] ) );
			
			
			$_POST ['id'] = array_flip ( explode ( ',', $_POST ['id'] ) );
			$user = Application_Model_Auth::getUser();
			$_POST ['admin'] = $user['id'];
									
			Application_Model_ContestManager::add ( $_POST );
			$id = Zend_Db_Table::getDefaultAdapter ()->lastInsertId ();
			
			foreach ( $_POST ['users'] as $key => $value ) {
				if ($key)
					Application_Model_ContestUserManager::add ( array (
							'contest' => $id,
							'user' => $key
					) );
			}
			
			foreach ( $_POST ['problems'] as $key => $value ) {
				if ($key)
					Application_Model_ContestProblemManager::add ( array (
							'contest' => $id,
							'problem' => $key
					) );
			}
			
										
			$this->view->id = $id;
			$this->view->success = "Contest successfully created.";
		}		
	}
	
	public function editAction() {
	
	}
	
	public function listAction() {
		$this->view->contests = Application_Model_ContestManager::getContests();
	}
	
	public function myAction() {
		$this->view->contests = Application_Model_ContestManager::getByAdmin(Application_Model_Auth::getUserId());
	}
	
	public function enroledAction() {
		$this->view->contests = Application_Model_ContestManager::getByEnroled(Application_Model_Auth::getUserId());
	}
	
	
	public function removeAction() {
	
	}
}
