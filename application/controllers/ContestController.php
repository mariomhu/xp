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
		
	}
	
	public function editAction() {
	
	}
	
	public function listAction() {
	
	}
	
	public function removeAction() {
	
	}
}
