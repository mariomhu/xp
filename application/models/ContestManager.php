<?php

class Application_Model_ContestManager extends Application_Model_Manager{
	
	public static $table = "contest";
	
	public static function add($values){
		return parent::add(array(
			"admin" => $values['admin'],
			"title" => $values['title'],
			"begin" => $values['begin'],
			"end" => $values['end'],
			"penalization" => $values['penalization'],
			"blind" => $values['blind'],
			"frozen" => $values['frozen'],
			"description" => $values['description']
		));
	}
	
	public static function set($values, $id){
		return parent::set(array(
			"admin" => $values['admin'],
			"title" => $values['title'],
			"begin" => $values['begin'],
			"end" => $values['end'],
			"blind" => $values['blind'],
			"frozen" => $values['frozen'],
			"description" => $values['description']
		), $id);
	}
	
	public static function getContests(){
		$select = self::select ();
		$select->joinInner ("user", "contest.admin = user.id",array(name));
		$db = Zend_Db_Table::getDefaultAdapter ();
		return $db->query ( $select )->fetchAll ();
	}
	
	public static function getById($id){
		$id = intval($id);
		$select = self::select ();
		$select->joinInner ( "id", "contest.id = problemtag.problem and problemtag.tag = $id" );
		$db = Zend_Db_Table::getDefaultAdapter ();
		return $db->query ( $select )->fetchAll ();			
	}
	
	public static function getByAdmin($admin){
		$id = intval($id);
		//$select = self::select (array("admin"=>$admin));
		$select = "select * from contest where admin=$admin";
		$db = Zend_Db_Table::getDefaultAdapter ();
		return $db->query ( $select )->fetchAll ();
	}
	
	public static function getByEnroled($user){
		$select = self::select();
		$select->joinInner("contestuser", "contest.id=contestuser.contest and contestuser.user=$user");
		$select->joinInner("user", "contest.admin = user.id",array(name));
		$db = Zend_Db_Table::getDefaultAdapter ();
		return $db->query ( $select )->fetchAll ();
	}
	
	/*public static function getContestRank(){
		select u.name,
		(select count(1)
		from submission s
		where s.problem = cp.problem
		and s.date between c.begin and c.end
		and s.user = cu.user
		and s.problem = 1) a,
		(select count(1)
		from submission s
		where s.problem = cp.problem
		and s.date between c.begin and c.end
		and s.user = cu.user
		and s.problem = 2) b,
		(select count(1)
		from submission s
		where s.problem = cp.problem
		and s.date between c.begin and c.end
		and s.user = cu.user
		and s.problem = 3) c,
		(select count(1)
		from submission s
		where s.problem = cp.problem
		and s.date between c.begin and c.end
		and s.user = cu.user
		and s.problem = 4) d,
		(select count(1)
		from submission s
		where s.problem = cp.problem
		and s.date between c.begin and c.end
		and s.user = cu.user
		and s.problem = 5) e,
		(select count(1)
		from submission s
		where s.problem = cp.problem
		and s.date between c.begin and c.end
		and s.user = cu.user
		and s.problem = 6) f,
		(select count(1)
		from submission s
		where s.problem = cp.problem
		and s.date between c.begin and c.end
		and s.user = cu.user
		and s.problem = 7) g,
		(select count(1)
		from submission s
		where s.problem = cp.problem
		and s.date between c.begin and c.end
		and s.user = cu.user
		and s.problem = 8) h,
		(select count(1)
		from submission s
		where s.problem = cp.problem
		and s.date between c.begin and c.end
		and s.user = cu.user
		and s.problem = 9) i,
		(select count(1)
		from submission s
		where s.problem = cp.problem
		and s.date between c.begin and c.end
		and s.user = cu.user
		and s.problem = 10) j
		from contestproblem cp
		join contest c on cp.contest = c.id
		join contestuser cu on cp.contest = cu.contest
		join user u on cu.user = u.id
		where c.id = 5				
	}*/
}

