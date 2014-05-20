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
		Application_Model_Auth::checkIsAdmin ();
		$this->view->contest = Application_Model_ContestManager::getAll(null, 'title');
		if ($_POST) {
				
			//$_POST ['active'] = ! ! $_POST ['active'];
			$_POST ['id'] = array_flip ( explode ( ',', $_POST ['id'] ) );
				
			Application_Model_ContestManager::add ( $_POST );
			/*$id = Zend_Db_Table::getDefaultAdapter ()->lastInsertId ();
			//move_uploaded_file ( $_FILES ['description'] ['tmp_name'], "../data/problems/" . $id . ".pdf" );
			//move_uploaded_file ( $_FILES ['cases'] ['tmp_name'], "../data/testcases/" . $id . ".zip" );
				
			foreach ( $_POST ['title'] as $key => $value ) {
				if ($key)
					Application_Model_ContestManager::add ( array (
							'contest' => $id,
							'tag' => $key
					) );
			}
				
			$this->view->id = $id;*/
			$this->view->success = "Problem successfully created.";
		}		
	}
	
	public function editAction() {
	
	}
	
	public function listAction() {
	
	}
	
	public function removeAction() {
	
	}
}
