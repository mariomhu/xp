<?php

class Application_Model_TagManager extends Application_Model_Manager{
	
	public static $table = "tag";
	
	public static function add($values){
		return parent::add(array(
			"name" => $values['name']
		));
	}
	
	public static function set($values, $id){
		return parent::set(array(
				"name" => $values['name']
		), $id);
	}
	
	public static function getByName($name){
		return parent::get(array("name" => $name));
	}
		
}

