<?php

class Application_Model_ProblemManager extends Application_Model_Manager{
	
	public static $table = "problem";
	
	public static function add($values){
		return parent::add(array(
			"title" => $values['title'],
			"active" => $values['active'],
			"timelimit" => $values['timelimit'],
			"from" => $values['from']
		));
	}
	
	public static function set($values, $id){
		return parent::set(array(
			"title" => $values['title'],
			"active" => $values['active'],
			"timelimit" => $values['timelimit'],
			"from" => $values['from']
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

