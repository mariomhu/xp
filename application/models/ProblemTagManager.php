<?php

class Application_Model_ProblemTagManager extends Application_Model_Manager{
	
	public static $table = "problemtag";
	
	public static function add($values){
		return parent::add(array(
			"problem" => $values['problem'],
			"tag" => $values['tag']
		));
	}
	
	public static function removeByProblem($problem){
		$db = Zend_Db_Table::getDefaultAdapter();
		$db->delete(static::$table, "problem = ".intval($problem));
	}
		
}

