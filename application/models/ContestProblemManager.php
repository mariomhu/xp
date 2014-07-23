<?php

class Application_Model_ContestProblemManager extends Application_Model_Manager{
	
	public static $table = "contestproblem";
	
	public static function add($values){
		return parent::add(array(
			"problem" => $values['problem'],
			"contest" => $values['contest']
		));
	}
	
	public static function getProblemsByContest($contest){
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = self::select();
		$select->joinInner('problem', "contestproblem.problem = problem.id and contestproblem.contest = $contest");
		return $db->query ($select)->fetchAll();
	}
	
	public static function removeByContest($contest){
		$db = Zend_Db_Table::getDefaultAdapter();
		$db->delete(static::$table, "contest = ".intval($contest));
	}
}

