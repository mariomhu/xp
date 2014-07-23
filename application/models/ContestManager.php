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
			"penalization" => $values['penalization'],
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
		--Critérios de ordenação: # de soluções, soma dos tempos

		select u.name,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 1
		   and s.state = 1) a_accept,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 1
		   and s.state <> 1) a_reject,		   
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 2
		   and s.state = 1) b_accept,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 2
		   and s.state <> 1) b_reject,		   
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 3
		   and s.state = 1) c_accept,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 3
		   and s.state <> 1) c_reject,		   
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 4
		   and s.state = 1) d_accept,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 4
		   and s.state <> 1) d_reject,		   
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 5
		   and s.state = 1) e_accept,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 5
		   and s.state <> 1) e_reject,		   
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 6
		   and s.state = 1) f_accept,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 6
		   and s.state <> 1) f_reject,		   
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 7
		   and s.state = 1) g_accept,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 7
		   and s.state <> 1) g_reject,		   
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 8
		   and s.state = 1) h_accept,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 8
		   and s.state <> 1) h_reject,		   
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 9
		   and s.state = 1) i_accept,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 9
		   and s.state <> 1) i_reject,		   
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 10
		   and s.state = 1) j_accept,
	   (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and u.id = s.user
		   and s.problem = 10
		   and s.state <> 1) j_reject	
  from contestproblem cp
   join contest c on cp.contest = c.id
   join contestuser cu on cp.contest = cu.contest
   join user u on cu.user = u.id   
where c.id = 5
order by a_accept + b_accept
				
	}*/
}

