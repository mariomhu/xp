<?php

class JudgeController extends Zend_Controller_Action {
	
	
	public function getSubmissionAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		Application_Model_Auth::checkIsJudge();
		
		$submission = Application_Model_SubmissionManager::getNext();
		if(!$submission) return;

		Application_Model_SubmissionManager::set(array('date_judge' => new Zend_Db_Expr('NOW()')), $submission['id']);
		$problem = Application_Model_ProblemManager::get($submission['problem']);

		echo $submission['id']."\n";
		echo $problem['id']."\n";
		echo $problem['version']."\n";
		echo $problem['timelimit']."\n";
	}
	
	public function setSubmissionAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		Application_Model_Auth::checkIsJudge();
		$submission = Application_Model_SubmissionManager::get($_POST['submission']);
		if(!$submission || $submission['state']) return;

		if($_POST['result'] == 1) $col = 'ac';
		elseif($_POST['result'] == 2) $col = 'pe';
		elseif($_POST['result'] == 3) $col = 'wa';
		elseif($_POST['result'] == 4) $col = 'ce';
		elseif($_POST['result'] == 5) $col = 're';
		else $col = 'tl';

		Application_Model_ProblemManager::increment($col, $submission['problem']);
		Application_Model_UserManager::increment($col, $submission['user']);
		Application_Model_SubmissionManager::set(array('state' => $_POST['result']), $submission['id']);
	}

	public function getSourceAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		Application_Model_Auth::checkIsJudge();
		$id = intval($_POST['submission']);
		readfile("../data/submissions/$id");
	}
	
	public function getCasesAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		Application_Model_Auth::checkIsJudge();
		$id = intval($_POST['problem']);
		readfile("../data/testcases/$id.zip");
	}
	
}
