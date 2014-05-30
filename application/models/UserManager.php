<?php

class Application_Model_UserManager extends Application_Model_Manager{
	
	public static $table = "user";
	
	public static function add($values){
		return parent::add(array(
			"name" => $values['name'],
			"login" => $values['login'],
			"email" => $values['email'],
			"institution" => $values['institution'],
			"page" => $values['page'],
			"password" => $values['password']
		));
	}
	
	public static function set($values, $id){
		return parent::set(array(
				"name" => $values['name'],
				"email" => $values['email'],
				"institution" => $values['institution'],
				"page" => $values['page'],
				"password" => $values['password']
		), $id);
	}
	
	public static function getByLogin($login){
		return parent::get(array("login = ?" => $login));
	}
	
	public static function getUserProblems($id){
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = self::select();
		$select->joinInner("bestsubmission", "bestsubmission.user = user.id");
		$select->joinInner("problem", "problem.id = bestsubmission.problem");
		$select->order('bestsubmission.id desc');
		return $db->query ($select)->fetchAll();		
	}
}

