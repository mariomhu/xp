<?php

class SubmissionController extends Zend_Controller_Action {
	
	public function indexAction() {
		Application_Model_Auth::checkIsUser();
		$user = Application_Model_Auth::getUser();
		$problema = $this->getParam ( "problem" );
		if($problema){
			$this->view->problem = Application_Model_ProblemManager::get($problema);
		}
		if($_POST){
			
			if($_POST['language'] != 1 && $_POST['language'] != 2) return;
				
			$problem = Application_Model_ProblemManager::get($_POST['problem']);
			if(!$problem){
				$this->view->error = "This problem does not exist.";
			}else{
				
				Application_Model_SubmissionManager::add(array(
					'problem' => $problem['id'],
					'user' => $user['id'],
					'language' => $_POST['language']
				));
				$id = Zend_Db_Table::getDefaultAdapter()->lastInsertId();
				
				if($_FILES['file']['tmp_name']) $source = file_get_contents($_FILES['file']['tmp_name']);
				else $source = $_POST['source'];
				file_put_contents("../data/submissions/$id", $source);
				
				$this->view->success = "Code successfully received.";
				
			}
		}
		if($this->getParam("problem")) $_POST['problem'] = $this->getParam("problem");
	}
	
	public function listAction() {
		
		$this->view->submissions = Application_Model_SubmissionManager::getSubmissions();
	}
	
	public function userAction(){
		Application_Model_Auth::checkIsUser();
		$user = Application_Model_Auth::getUser();
		$this->view->submissionsUser = Application_Model_SubmissionManager::getUserSubmissions($user['id']);
	}
		
	public function rankAction() {
		$this->view->users = Application_Model_SubmissionManager::getRanking();
		$this->view->title = "Ranking";
	}
	
}
