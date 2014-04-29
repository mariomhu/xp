<?php

class Application_Model_UserManager extends Application_Model_Manager{
	
	public static $table = "user";
	
	public static function add($values){
		return parent::add(array(
			"name" => $values['name'],
			"login" => $values['login'],
			"email" => $values['email'],
			"institution" => $values['institution'],
			"nickname" => $values['nickname'],
			"page" => $values['page'],
			"password" => $values['password']
		));
	}
	
	public static function set($values, $id){
		return parent::set(array(
				"name" => $values['name'],
				"institution" => $values['institution'],
				"nickname" => $values['nickname'],
				"page" => $values['page'],
				"password" => $values['password']
		), $id);
	}
	
	public static function getByLogin($login){
		return parent::get(array("login = ?" => $login));
	}
	
}

