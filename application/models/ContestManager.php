<?php

class Application_Model_ProblemManager extends Application_Model_Manager{
	
	public static $table = "contest";
	
	public static function add($values){
		return parent::add(array(
			"admin" => $values['admin'],
			"title" => $values['title'],
			"begin" => $values['begin'],
			"end" => $values['end'],
			"blind" => $values['blind'],
			"frozen" => $values['frozen'],
			"description" => $values['description']
		));
	}
	
	public static function set($values, $id){
		return parent::set(array(
			"admin" => $values['admin'],
			"title" => $values['title'],
			"begin" => $values['begin'],
			"end" => $values['end'],
			"blind" => $values['blind'],
			"frozen" => $values['frozen'],
			"description" => $values['description']
		), $id);
	}
	
	public static function getByTag($tag){
		$tag = intval($tag);
		$select = self::select ();
		$select->joinInner ( "problemtag", "problem.id = problemtag.problem and problemtag.tag = $tag" );
		$db = Zend_Db_Table::getDefaultAdapter ();
		return $db->query ( $select )->fetchAll ();
	}
	
}

