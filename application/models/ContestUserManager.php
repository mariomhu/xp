<?php

class Application_Model_ContestUserManager extends Application_Model_Manager{
	
	public static $table = "contestuser";
	
	public static function add($values){
		return parent::add(array(
			"user" => $values['user'],
			"contest" => $values['contest']
		));
	}
}

