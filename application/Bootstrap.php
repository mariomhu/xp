<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initBootstrap()
    {
    	session_start();
		foreach($_POST as $key=>$value){
			if($key != "password" && $key != "source") $_POST[$key] = htmlspecialchars($value);
		}
	
    }
}

