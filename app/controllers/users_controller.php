<?php
class UsersController extends AppController 
{

	var $name = 'Users';
	/**
	* Log a user in
	* Provided by AuthComponent
	*/
	function login() 
	{
	
	}

	/**
	* Log a user out
	* Provided by AuthComponent
	*/
	function logout() 
	{
		$this->redirect($this->Auth->logout());
	
	}	
}
?>