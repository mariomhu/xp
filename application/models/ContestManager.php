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
	
	public static function getContestRank($p,$c){
	
		$select ="select
   a.name,
   a.penalization,
   sum(a.a_accept)a_accept,
   sum(a.b_accept)b_accept,
   sum(a.c_accept)c_accept,
   sum(a.d_accept)d_accept,
   sum(a.e_accept)e_accept,
   sum(a.f_accept)f_accept,
   sum(a.g_accept)g_accept,
   sum(a.h_accept)h_accept,
   sum(a.i_accept)i_accept,
   sum(a.j_accept)j_accept,
   sum(a.a_reject)a_reject,
   sum(a.b_reject)b_reject,
   sum(a.c_reject)c_reject,
   sum(a.d_reject)d_reject,
   sum(a.e_reject)e_reject,
   sum(a.f_reject)f_reject,
   sum(a.g_reject)g_reject,
   sum(a.h_reject)h_reject,
   sum(a.i_reject)i_reject,
   sum(a.j_reject)j_reject,
   sum(
     if(a_accept>0,1,0) 
   + if(b_accept>0,1,0) 
   + if(c_accept>0,1,0) 
   + if(d_accept>0,
   1,
   0) + if(e_accept>0,
   1,
   0) + if(f_accept>0,
   1,
   0) + if(g_accept>0,
   1,
   0) + if(h_accept>0,
   1,
   0) + if(i_accept>0,
   1,
   0) + if(j_accept>0,
   1,
   0)) total_accepted,
   sum(a_reject + b_reject + c_reject + d_reject + e_reject + f_reject + g_reject + h_reject + i_reject + j_reject) * penalization total_penalization,
   (a_accept + b_accept + c_accept + d_accept + e_accept + f_accept + g_accept + h_accept + i_accept + j_accept) total_time
from
   (    select
      distinct        u.name,
      c.penalization,
      (select
         IFNULL(MIN(s.time),
         0)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 1       
         and s.state = 1) a_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 1       
         and s.state <> 1) a_reject,
      (select
         IFNULL(MIN(s.time),
         0)            
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 2       
         and s.state = 1) b_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 2       
         and s.state <> 1) b_reject,
      (select
         IFNULL(MIN(s.time),
         0)            
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 3       
         and s.state = 1) c_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 3       
         and s.state <> 1) c_reject,
      (select
         IFNULL(MIN(s.time),
         0)            
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 4       
         and s.state = 1) d_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 4       
         and s.state <> 1) d_reject,
      (select
         IFNULL(MIN(s.time),
         0)            
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 5       
         and s.state = 1) e_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 5       
         and s.state <> 1) e_reject,
      (select
         IFNULL(MIN(s.time),
         0)            
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 6       
         and s.state = 1) f_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 6       
         and s.state <> 1) f_reject,
      (select
         IFNULL(MIN(s.time),
         0)            
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 7       
         and s.state = 1) g_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 7       
         and s.state <> 1) g_reject,
      (select
         IFNULL(MIN(s.time),
         0)            
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 8       
         and s.state = 1) h_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 8       
         and s.state <> 1) h_reject,
      (select
         IFNULL(MIN(s.time),
         0)            
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 9       
         and s.state = 1) i_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 9       
         and s.state <> 1) i_reject,
      (select
         IFNULL(MIN(s.time),
         0)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 10       
         and s.state = 1) j_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = 10       
         and s.state <> 1) j_reject      
   from
      contestproblem cp     
   join
      contest c 
         on cp.contest = c.id     
   join
      contestuser cu 
         on cp.contest = cu.contest     
   join
      user u 
         on cu.user = u.id        
   join
      submission s1 
         on s1.problem = cp.problem                      
         and s1.date between c.begin and c.end       
         and u.id = s1.user         
   where
      c.id = 5
   ) a  
group by
   a.name,
   a.penalization,
  -- total_accepted,
   penalization  /*
group by
   a.a_accept,
   a.b_accept,
   a.c_accept,
   a.d_accept,
   a.e_accept,
   a.f_accept,
   a.g_accept,
   a.h_accept,
   a.i_accept,
   a.j_accept,
   a.a_reject,
   a.b_reject,
   a.c_reject,
   a.d_reject,
   a.e_reject,
   a.f_reject,
   a.g_reject,
   a.h_reject,
   a.i_reject,
   a.j_reject,
   a.name,
   a.penalization,
   total_accepted,
   penalization*/  
order by
   total_accepted desc,
   total_penalization,
   total_time
   ";
		$db = Zend_Db_Table::getDefaultAdapter ();
		return $db->query ( $select )->fetchAll ();
	}
	
	/*public static function getContestRank($p,$c){
		
		$select ="select
   		a.name,
   		a.penalization,
   		sum(a.a_accept)a_accept,
  		sum(a.b_accept)b_accept,
   		sum(a.c_accept)c_accept,
   sum(a.d_accept)d_accept,
   sum(a.e_accept)e_accept,
   sum(a.f_accept)f_accept,
   sum(a.g_accept)g_accept,
   sum(a.h_accept)h_accept,
   sum(a.i_accept)i_accept,
   sum(a.j_accept)j_accept,
   sum(a.a_reject)a_reject,
   sum(a.b_reject)b_reject,
   sum(a.c_reject)c_reject,
   sum(a.d_reject)d_reject,
   sum(a.e_reject)e_reject,
   sum(a.f_reject)f_reject,
   sum(a.g_reject)g_reject,
   sum(a.h_reject)h_reject,
   sum(a.i_reject)i_reject,
   sum(a.j_reject)j_reject,
   sum(
     if(a_accept>0,1,0) 
   + if(b_accept>0,1,0) 
   + if(c_accept>0,1,0) 
   + if(d_accept>0,
   1,
   0) + if(e_accept>0,
   1,
   0) + if(f_accept>0,
   1,
   0) + if(g_accept>0,
   1,
   0) + if(h_accept>0,
   1,
   0) + if(i_accept>0,
   1,
   0) + if(j_accept>0,
   1,
   0)) total_accepted,
   sum(a_reject + b_reject + c_reject + d_reject + e_reject + f_reject + g_reject + h_reject + i_reject + j_reject) * penalization total_penalization,
   (a_accept + b_accept + c_accept + d_accept + e_accept + f_accept + g_accept + h_accept + i_accept + j_accept) total_time
from
   (    select
      distinct        u.name,
      c.penalization,
      (select
         IFNULL(MIN(s.time),
         0)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['1']."       
         and s.state = 1) a_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['1']."       
         and s.state <> 1) a_reject,
      (select
         IFNULL(MIN(s.time),
         0)            
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['2']."       
         and s.state = 1) b_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['2']."       
         and s.state <> 1) b_reject,
      (select
         IFNULL(MIN(s.time),
         0)            
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['3']."       
         and s.state = 1) c_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['3']."       
         and s.state <> 1) c_reject,
      (select
         IFNULL(MIN(s.time),
         0)            
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['4']."       
         and s.state = 1) d_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['4']."       
         and s.state <> 1) d_reject,
      (select
         IFNULL(MIN(s.time),
         0)            
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['5']."       
         and s.state = 1) e_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['5']."       
         and s.state <> 1) e_reject,
      (select
         IFNULL(MIN(s.time),
         0)            
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['6']."       
         and s.state = 1) f_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['6']."       
         and s.state <> 1) f_reject,
      (select
         IFNULL(MIN(s.time),
         0)            
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['7']."       
         and s.state = 1) g_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['7']."       
         and s.state <> 1) g_reject,
      (select
         IFNULL(MIN(s.time),
         0)            
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['8']."       
         and s.state = 1) h_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['9']."       
         and s.state <> 1) h_reject,
      (select
         IFNULL(MIN(s.time),
         0)            
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['9']."       
         and s.state = 1) i_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['9']."       
         and s.state <> 1) i_reject,
      (select
         IFNULL(MIN(s.time),
         0)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['10']."       
         and s.state = 1) j_accept,
      (select
         count(1)             
      from
         submission s            
      where
         s.problem = cp.problem             
         and s.date between c.begin and c.end       
         and u.id = s.user       
         and s.problem = ".$p['10']."       
         and s.state <> 1) j_reject      
   from
      contestproblem cp     
   join
      contest c 
         on cp.contest = c.id     
   join
      contestuser cu 
         on cp.contest = cu.contest     
   join
      user u 
         on cu.user = u.id        
   join
      submission s1 
         on s1.problem = cp.problem                      
         and s1.date between c.begin and c.end       
         and u.id = s1.user         
   where
      c.id = ".$c."
   ) a  
group by
   a.name,
   a.penalization,
 
order by
   total_accepted desc,
   total_penalization,
   total_time";
		$db = Zend_Db_Table::getDefaultAdapter ();
		return $db->query ( $select )->fetchAll ();
	}
	*/
}

