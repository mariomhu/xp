<?php

class Application_Model_Manager
{

	public static function add($table, $values){
		$db = Zend_Db_Table::getDefaultAdapter();
		return $db->insert($table, $values);
	}
	
	public static function select($table, $where = null, $order = null){
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = $db->select()->from($table);
		if(is_array($where)) foreach($where as $key=>$value) $select->where($key, $value);
		elseif($where) $select->where('id = ?', $where);
		if($order) $select->order($order);
		return $select;
	}
	
	public static function get($table, $where = null){
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = self::select($table, $where)->limit(1);	
		return $db->query($select)->fetch();
	}
	
	public static function getAll($table, $where = null, $order = null){
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = self::select($table, $where);	
		return $db->query($select)->fetchAll();
	}
	
	public static function remove($table, $id){
		$db = Zend_Db_Table::getDefaultAdapter();
		$db->delete($table, "id = ".intval($id));
	}
	
	public static function set($table, $values, $id){
		$db = Zend_Db_Table::getDefaultAdapter();
		foreach($values as $key=>$value) if($value === null) unset($values[$key]);
		return $db->update($table, $values, "id = ".intval($id));
	}
	
}

