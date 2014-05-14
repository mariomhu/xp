<?php

class Application_Model_TagManager extends Application_Model_Manager{
	
	public static $table = "tag";
	
	public static function add($values){
		return parent::add(array(
			"name" => $values['name']
		));
	}
	
	public static function set($values, $id){
		return parent::set(array(
				"name" => $values['name']
		), $id);
	}
	
	public static function getByName($name){
		return parent::get(array("name" => $name));
	}
		
	public static function getByProblem($id){
		$id = intval($id);
		$select = self::select();
		$select->joinInner("problemtag", "problemtag.problem = $id AND problemtag.tag = tag.id" );
		$db = Zend_Db_Table::getDefaultAdapter();
		return $db->query($select)->fetchAll();
	}
}

