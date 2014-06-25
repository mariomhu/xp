<?php

class Application_Model_ContestManager extends Application_Model_Manager{
	
	public static $table = "contest";
	
	public static function add($values){
		return parent::add(array(
			"admin" => $values['admin'],
			"title" => $values['title'],
			"begin" => $values['begin'],
			"end" => $values['end'],
			"penalization" => $values['penalization'],
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
	
	public static function getContests(){
		$select = self::select ();
		$select->joinInner ("user", "contest.admin = user.id",array(name));
		$db = Zend_Db_Table::getDefaultAdapter ();
		return $db->query ( $select )->fetchAll ();
	}
	
	public static function getById($id){
		$id = intval($id);
		$select = self::select ();
		$select->joinInner ( "id", "contest.id = problemtag.problem and problemtag.tag = $id" );
		$db = Zend_Db_Table::getDefaultAdapter ();
		return $db->query ( $select )->fetchAll ();			
	}
	
	public static function getByAdmin($admin){
		$id = intval($id);
		//$select = self::select (array("admin"=>$admin));
		$select = "select * from contest where admin=$admin";
		$db = Zend_Db_Table::getDefaultAdapter ();
		return $db->query ( $select )->fetchAll ();
	}
	
	public static function getByEnroled($user){
		$select = self::select();
		$select->joinInner("contestuser", "contest.id=contestuser.contest and contestuser.user=$user");
		$select->joinInner("user", "contest.admin = user.id",array(name));
		$db = Zend_Db_Table::getDefaultAdapter ();
		return $db->query ( $select )->fetchAll ();
	}
	
}

