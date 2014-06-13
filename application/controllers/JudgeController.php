<?php

class JudgeController extends Zend_Controller_Action {
	
	
	public function getSubmissionAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		Application_Model_Auth::checkIsJudge();
		
		$submission = Application_Model_SubmissionManager::getNext();
		if(!$submission) return;

		Application_Model_SubmissionManager::set(array('date_judge' => new Zend_Db_Expr('CURRENT_TIMESTAMP()')), $submission['id']);
		$problem = Application_Model_ProblemManager::get($submission['problem']);

		echo $submission['id']."\n";
		echo $submission['language']."\n";
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

		Application_Model_SubmissionManager::set(array('state' => $_POST['result'], 'time' => $_POST['time']), $submission['id']);

		$submission = Application_Model_SubmissionManager::get($_POST['submission']);
		
		if($_POST['result'] == 1) $col = 'ac';
		elseif($_POST['result'] == 2) $col = 'pe';
		elseif($_POST['result'] == 3) $col = 'wa';
		elseif($_POST['result'] == 4) $col = 'ce';
		elseif($_POST['result'] == 5) $col = 're';
		else $col = 'tl';
		
		Application_Model_ProblemManager::increment($col, $submission['problem']);
		Application_Model_UserManager::increment($col, $submission['user']);

		$anterior = Application_Model_SubmissionManager::get(array(
			'user = ?'=>$submission['user'],
			'problem = ?'=>$submission['problem'],
			'state >= ?'=>1,
			'id != ?'=>$submission['id']
		));	
		
		if(!$anterior){
			Application_Model_ProblemManager::increment('tried', $submission['problem']);
			Application_Model_UserManager::increment('tried', $submission['user']);
		}
		
		if($_POST['result'] == 1){
			
			$best = Application_Model_BestSubmissionManager::get(array(
				'user = ?'=>$submission['user'],
				'problem = ?'=>$submission['problem'],
			));
			
			if(!$best){
				Application_Model_ProblemManager::increment('solved', $submission['problem']);
				Application_Model_UserManager::increment('solved', $submission['user']);
			}
			
			if(!$best || $best['time'] > $submission['time']){
				if($best) Application_Model_BestSubmissionManager::remove($best['id']);
				$new = $submission;
				$new['submission'] = $submission['id'];
				Application_Model_BestSubmissionManager::add($new);
			}
			
		}
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
		header("Content-Transfer-Encoding: binary");
		header('Content-type: application/zip');
		Application_Model_Auth::checkIsJudge();
		$id = intval($_POST['problem']);
		readfile("../data/testcases/$id.zip");
	}
	
}
