<?php

class Application_Model_Manager
{
	public static $table;
	
	public static function add($values){
		$db = Zend_Db_Table::getDefaultAdapter();
		return $db->insert(static::$table, $values);
	}
	
	public static function select($where = null, $order = null){
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = $db->select()->from(static::$table);
		if(is_array($where)) foreach($where as $key=>$value) $select->where($key, $value);
		elseif($where) $select->where('id = ?', $where);
		if($order) $select->order($order);
		return $select;
	}
	
	public static function get($where = null){
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = self::select($where)->limit(1);
		return $db->query($select)->fetch();
	}
	
	public static function getAll($where = null, $order = null){
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = self::select($where, $order);	
		return $db->query($select)->fetchAll();
	}
	
	public static function remove($id){
		$db = Zend_Db_Table::getDefaultAdapter();
		$db->delete(static::$table, "id = ".intval($id));
	}

	public static function set($values, $id){
		$db = Zend_Db_Table::getDefaultAdapter();
		foreach($values as $key=>$value) if($value === null) unset($values[$key]);
		return $db->update(static::$table, $values, "id = ".intval($id));
	}
	
	public static function increment($column, $id){
		$db = Zend_Db_Table::getDefaultAdapter();
		return $db->update(static::$table, array("$column" => new Zend_Db_Expr("$column + 1")), "id = ".intval($id));
	}
	
}

