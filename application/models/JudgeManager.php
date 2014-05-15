<?php

class Application_Model_JudgeManager extends Application_Model_Manager{
	
	public static $table = "judge";
	
	public static function add($values){
		return parent::add(array(
			"key" => $values['key'],
		));
	}
	
	public static function set($values, $id){
		return parent::set(array(
				"key" => $values['key'],
		), $id);
	}
	
}

