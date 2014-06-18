<?php

class Application_Model_ContestProblemManager extends Application_Model_Manager{
	
	public static $table = "contestproblem";
	
	public static function add($values){
		return parent::add(array(
			"problem" => $values['problem'],
			"contest" => $values['contest']
		));
	}
}

