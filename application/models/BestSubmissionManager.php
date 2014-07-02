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
	
	public static function getBest(){
			$select = self::select();
			$select->limit(10);
			$select = "Select name, login, email, user.id as user_id, count(bestsubmission.user) as con from
				user join bestsubmission on user.id=bestsubmission.user
				group by bestsubmission.user order by con desc";
			$db = Zend_Db_Table::getDefaultAdapter ();
			return $db->query ( $select )->fetchAll ();
		}
}