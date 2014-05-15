<?php

class SubmissionController extends Zend_Controller_Action {
	
	public function indexAction() {
		Application_Model_Auth::checkIsUser();
		$user = Application_Model_Auth::getUser();
		
		if($_POST){
			
			if($_POST['language'] != 0 && $_POST['language'] != 1) return;
				
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
	
	}
		
	public function rankAction() {
	
	}
	
	public function userAction() {
	
	}

	public function judgeGetAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		Application_Model_Auth::checkIsJudge();
		
		$submission = Application_Model_SubmissionManager::getNext();
		if(!$submission) return;
		$problem = Application_Model_ProblemManager::get($submission['problem']);

		echo $submission['id']."\n";
		echo $problem['id']."\n";
		echo $problem['version']."\n";
		echo $problem['timelimit']."\n";
	}
	
	public function judgeSetAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		Application_Model_Auth::checkIsJudge();
		
		
		
	}
	
}
