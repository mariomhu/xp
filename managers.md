Todos os managers extendem a seguinte classe:

Manager.php
  add($values)                            // insere uma array no banco
  select($where = null, $order = null)    // retorna um Zend_Db_Select da tabela
  get($where = null)                      // retorna uma array com o primeiro registro encontrado
  getAll($where = null, $order = null)    // retorna todos os registro encontrados
	remove($id)                             // remove o registro com o id informado
  set($values, $id)                       // recebe uma array com os novos valores para a tupla com o id informado
	increment($column, $id)                 // incrementa o valor da conluna informada
	
Parametros opcional $where                                  
  // pode ser o id do registro ou uma array com confições, ex.:
  // array("valor > ?":5, "total < ?":2), usar ? por segurança, o zend veirifica se não é inject
Parametro opcional $order
  // o nome da coluna em que os registros devem vir ordenados

Exemplos de uso:
=========

Application_Model_UserManager::add($_POST);
// insere os dados recebidos por post na tabela user

Application_Model_UserManager::get(5); 
// retorna o usuario com id 5

Application_Model_UserManager::get(array("email = ?" => "teste@teste.com"));
// retorna o usuarios com o email informado

Application_Model_UserManager::increment("ac", 7);
// incrementa a coluna ac do usuario com id 7

$select = Application_Model_UserManager::select()
          ->join("submissions", "user.id = submissions.user")
          ->group("problem")->order("user.name");
//Cria um select da tabela user combinado com submissions e agrupado por user.name
$db = Zend_Db_Table::getDefaultAdapter(); 
//pega o link do banco
$result = $db->query($select)->fetchAll(); 
//executa o select e coloca o resultado em uma array
//$db->query() tambem pode receber uma string como a query
//mais sobre o Zend_Db_Select: http://framework.zend.com/manual/1.12/en/zend.db.select.html





//http://framework.zend.com/manual/1.12/en/zend.db.select.html
