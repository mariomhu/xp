<?php 

class BestSubmissionController extends Zend_Controller_Action {
	
	public function listAction() {
		$this->view->bestsubmissions = Application_Model_BestSubmissionManager::getBestBestSubmissions();
	}
}

?>