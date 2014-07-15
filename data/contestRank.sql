select u.name
  from contestproblem cp
   join contest c on cp.contest = c.id
   join submission s on cp.problem = s.problem
   join contestuser cu on cp.contest = cu.contest
   join user u on cu.user = u.id   
where c.id = 5
  and s.date between c.begin and c.end
  
select u.name, 
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and s.problem = 1) a,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and s.problem = 2) b,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and s.problem = 3) c,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and s.problem = 4) d,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and s.problem = 5) e,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and s.problem = 6) f,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and s.problem = 7) g,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and s.problem = 8) h,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and s.problem = 9) i,
       (select count(1) 
          from submission s 
         where s.problem = cp.problem
           and s.date between c.begin and c.end
		   and s.problem = 10) j		   
  from contestproblem cp
   join contest c on cp.contest = c.id
   join contestuser cu on cp.contest = cu.contest
   join user u on cu.user = u.id   
where c.id = 5
