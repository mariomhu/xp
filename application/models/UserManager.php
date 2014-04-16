<?php

class Application_Model_UserManager
{
    public static function add($values){
		$db = Zend_Db_Table::getDefaultAdapter();
		return $db->insert("user", array(
			"name" => $values['name'],
			"email" => $values['email'],
			"institution" => $values['institution'],
			"nick" => $values['nick'],
			"password" => $values['password']
		));
	}
	
	public static function select($where = null, $order = null){
		return Application_Model_Manager::select('user', $where, $order);
	}
	
	public static function get($where){
		return Application_Model_Manager::get('user', $where = null);
	}
	
	public static function getAll($where = null, $order = null){
		return Application_Model_Manager::getAll('user', $where, $order);
	}
	
}

