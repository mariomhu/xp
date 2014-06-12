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
	
	public static function getRankById($id){
		$id = intval($id);
		$select = self::select();
		$select->joinInner("bestsubmission", "problem.id=bestsubmission.problem and problem.id= $id " );
		$select->joinInner("user", "user.id=bestsubmission.user")->order("time");
		$db = Zend_Db_Table::getDefaultAdapter();
		return $db->query ($select)->fetchAll();
	}

	public static function getUserProblems($id){
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = self::select();
		$select->joinInner("bestsubmission", "bestsubmission.problem = problem.id and bestsubmission.user = $id", array("time", "idSub"=>"id", "date", "language"));
		$select->order('bestsubmission.id desc');
		return $db->query ($select)->fetchAll();
	}
	
	public static function getLast(){
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = self::select();
		$select->limit(10);
		$select->order('date desc');
		return $db->query ($select)->fetchAll();
	}
}

