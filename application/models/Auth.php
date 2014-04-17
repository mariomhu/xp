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

	public static function isAdmin(){
		return $_SESSION['login']['admin'];
	}

	public static function isLogged(){
		return isset($_SESSION['login']);
	}
	
}

