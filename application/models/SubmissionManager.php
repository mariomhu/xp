<?php

class Application_Model_SubmissionManager extends Application_Model_Manager{
	
	public static $table = "submission";
	
	public static function add($values){
		return parent::add(array(
			"problem" => $values['problem'],
			"user" => $values['user'],
			"language" => $values['language']
		));
	}
	
	public static function set($values, $id){
		return parent::set(array(
			"problem" => $values['problem'],
			"user" => $values['user'],
			"time" => $values['time'],
			"language" => $values['language']
		), $id);
	}
	
}

