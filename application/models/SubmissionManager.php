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
			"date_judge" => $values['date_judge'],
			"language" => $values['language'],
			"state" => $values['state']
		), $id);
	}
	
	public static function getNext(){
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = 'SELECT * FROM submission WHERE (TIMEDIFF(NOW(),date_judge) > "00:05:00" OR date_judge IS NULL) AND state = 0 ORDER BY id LIMIT 1';
		return $db->query($select)->fetch();
	}
	
	public static function getSubmissions(){
		$select = self::select();
		$select->joinInner("user", "user.id=submission.user", array("login","name"));
		$select->order('submission.date desc');
		$select->joinInner("problem", "submission.problem=problem.id", array("title"));
		$select->limit(50);
		$db = Zend_Db_Table::getDefaultAdapter();
		return $db->query ($select)->fetchAll();
	}
	
	public static function getUserSubmissions($id){
		$select = self::select();
		$select->joinInner("user", "user.id=submission.user and user.id=$id");
		$select->joinInner("problem", "submission.problem=problem.id", array("title"));
		$select->order('submission.date desc');
		$db = Zend_Db_Table::getDefaultAdapter();
		return $db->query ($select)->fetchAll();
	}
	
	public static function getLast(){
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = self::select();
		$select->join(array('problem'), 'problem.id = submission.problem');
		$select->join(array('user'), 'user.id = submission.user');
		$select->limit(7);
		$select->order('submission.date desc');
		return $db->query ($select)->fetchAll();
	}
	
	public static function getRanking(){
		$select = "Select name, login, user.id as user_id, count(bestsubmission.user) as con from
				user join bestsubmission on user.id=bestsubmission.user
				group by bestsubmission.user order by con desc";
		$db = Zend_Db_Table::getDefaultAdapter ();
		return $db->query ( $select )->fetchAll ();
	}
}

