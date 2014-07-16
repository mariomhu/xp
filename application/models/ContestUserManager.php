<?php

class Application_Model_ContestUserManager extends Application_Model_Manager{
	
	public static $table = "contestuser";
	
	public static function add($values){
		return parent::add(array(
			"user" => $values['user'],
			"contest" => $values['contest']
		));
	}
	
	public static function getUsersByContest($contest){
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = self::select();
		$select->joinInner('user', "contestuser.user = user.id and contestuser.contest = $contest");
		return $db->query ($select)->fetchAll();
	}
}

