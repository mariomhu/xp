<?php

class Application_Model_BestSubmissionManager extends Application_Model_Manager{
	
	public static $table = "bestsubmission";
	
	public static function add($values){
		return parent::add(array(
			"problem" => $values['problem'],
			"user" => $values['user'],
			"language" => $values['language'],
			"time" => $values['time'],
			"date" => $values['date'],
			"submission" => $values['submission'],
		));
	}
	
	public static function set($values, $id){
		return parent::set(array(
			"problem" => $values['problem'],
			"user" => $values['user'],
			"language" => $values['language'],
			"time" => $values['time'],
			"date" => $values['date'],
			"submission" => $values['submission']
		), $id);
	}
}