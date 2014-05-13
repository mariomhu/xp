<?php

class Application_Model_ProblemManager extends Application_Model_Manager{
	
	public static $table = "problem";
	
	public static function add($values){
		return parent::add(array(
			"title" => $values['title'],
			"active" => $values['active'],
			"timelimit" => $values['timelimit'],
			"author" => $values['author']
		));
	}
	
	public static function set($values, $id){
		return parent::set(array(
			"title" => $values['title'],
			"active" => $values['active'],
			"timelimit" => $values['timelimit'],
			"author" => $values['author']
		), $id);
	}
	
}

