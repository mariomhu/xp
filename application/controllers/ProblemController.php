<?php
class ProblemController extends Zend_Controller_Action {
	public function indexAction() {
		$id = $this->getParam ( "id" );
		
		$problem = Application_Model_ProblemManager::get( $id );
		
		$this->view->submissions = $problem ['ac'] + $problem ['pe'] + $problem ['wa'] + $problem ['ce'] + $problem ['re'] + $problem ['tl'];
		$this->view->problem = $problem;
		
		$this->view->tags = Application_Model_TagManager::getByProblem($id);
		
		$this->view->ranking = Application_Model_ProblemManager::getRankById($id);
		
		
	}
	public function listAction() {
		$tag = intval ( $this->getParam ( "tag" ));
		if ($tag) {
			$this->view->problems = Application_Model_ProblemManager::getByTag($tag);
			$tag = Application_Model_TagManager::get ( $tag );
			$this->view->title = "Problems - $tag[name]";
		} elseif($_POST['search']) {
			$this->view->title = "Search \"$_POST[search]\"";
			$this->view->problems = Application_Model_ProblemManager::search($_POST['search']);
		}else{
			$this->view->title = "All Problem";
			$this->view->problems = Application_Model_ProblemManager::getAll ();
		}
	}
	public function registerAction() {
		Application_Model_Auth::checkIsAdmin ();
		$this->view->tags = Application_Model_TagManager::getAll ( null, 'name' );
		if ($_POST) {
			
			$_POST ['active'] = ! ! $_POST ['active'];
			$_POST ['tags'] = array_flip ( explode ( ',', $_POST ['tags'] ) );
			
			Application_Model_ProblemManager::add ( $_POST );
			$id = Zend_Db_Table::getDefaultAdapter ()->lastInsertId ();
			move_uploaded_file ( $_FILES ['description'] ['tmp_name'], "../data/problems/" . $id . ".pdf" );
			move_uploaded_file ( $_FILES ['cases'] ['tmp_name'], "../data/testcases/" . $id . ".zip" );
			
			foreach ( $_POST ['tags'] as $key => $value ) {
				if ($key)
					Application_Model_ProblemTagManager::add ( array (
							'problem' => $id,
							'tag' => $key 
					) );
			}
			
			$this->view->id = $id;
			$this->view->success = "Problem successfully created.";
		}
	}
	public function editAction() {
		Application_Model_Auth::checkIsAdmin ();
		$this->view->tags = Application_Model_TagManager::getAll ( null, 'name' );
		$id = $this->getParam ( "id" );
		if ($_POST) {
			
			$_POST ['active'] = ! ! $_POST ['active'];
			$_POST ['tags'] = array_flip ( explode ( ',', $_POST ['tags'] ) );
			
			Application_Model_ProblemManager::set ( $_POST, $id );
			Application_Model_ProblemManager::increment ( "version", $id );
			
			if ($_FILES ['description'] ['tmp_name'])
				move_uploaded_file ( $_FILES ['description'] ['tmp_name'], "../data/problems/" . $id . ".pdf" );
			if ($_FILES ['cases'] ['tmp_name'])
				move_uploaded_file ( $_FILES ['cases'] ['tmp_name'], "../data/testcases/" . $id . ".zip" );
			
			Application_Model_ProblemTagManager::removeByProblem ( $id );
			foreach ( $_POST ['tags'] as $key => $value ) {
				if ($key)
					Application_Model_ProblemTagManager::add ( array (
							'problem' => $id,
							'tag' => $key 
					) );
			}
			
			$this->view->id = $id;
			$this->view->success = "Problem has been changed.";
		} else {
			$_POST = Application_Model_ProblemManager::get ( $id );
			$tags = Application_Model_ProblemTagManager::getAll ( array (
					"problem = ?" => $id 
			) );
			foreach ( $tags as $tag )
				$_POST ['tags'] [$tag ['tag']] = true;
		}
	}
	public function removeAction() {
		$this->_helper->layout ()->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ( true );
		Application_Model_Auth::checkIsAdmin ();
		$id = $this->getParam ( 'id' );
		Application_Model_ProblemManager::remove ( $id );
		$this->_helper->redirector ( 'list', 'problem' );
	}
	public function pdfAction() {
		$this->_helper->layout ()->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ( true );
		$id = intval ( $this->getParam ( "id" ) );
		header ( 'Content-type: application/pdf' );
		header ( 'Content-Disposition: inline; filename="UFFS - Problem ' . $id . '.pdf"' );
		header ( 'Content-Transfer-Encoding: binary' );
		header ( 'Content-Length: ' . filesize ( "../data/problems/$id.pdf" ) );
		header ( 'Accept-Ranges: bytes' );
		@readfile ( "../data/problems/$id.pdf" );
	}
}
