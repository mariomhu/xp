<?php

class Application_Model_Auth{

	public static function login($user){
		$_SESSION['login'] = $user;
	}

	public static function logout(){
		unset($_SESSION['login']);
	}

	public static function getUser(){
		return $_SESSION['login'];
	}
	
	public static function getUserId(){
		return $_SESSION['login']['id'];
	}

	public static function isAdmin(){
		return $_SESSION['login']['admin'];
	}

	public static function checkIsUser(){
		if(!self::getUser()) self::redirect();
	}
	
	public static function checkIsAdmin(){
		if(!self::isAdmin()) self::redirect();
	}
	
	public static function redirect(){
		$redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
		$redirector->gotoSimpleAndExit('index','index');
	}
	
}

