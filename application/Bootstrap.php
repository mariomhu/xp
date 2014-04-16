<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initBootstrap()
    {
		foreach($_POST as $key=>$value){
			if($key != "password") $_POST[$key] = htmlspecialchars($value);
		}
    }
}

