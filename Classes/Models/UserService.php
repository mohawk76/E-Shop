<?php

namespace Shop\Models;

class UserService extends \AnvilPHP\Model
{
	/**
	 * Check that the user is logged in
	 * @return boolean
	 */
	public function isLogged()
	{
		if(isset(Session::getInstance()->user))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function getUser(string $login)
	{
		return $this->database->sendQuery((new \AnvilPHP\Database\Select())->From('users')->Where('login = "'.$login.'"'));
	}
	
	public function addUser()
	{
		return (new \AnvilPHP\Database\Insert("Users"))->Values(func_get_args());
	}
	
	public function deleteUser($id)
	{
		$result = $this->database->sendQuery((new \AnvilPHP\Database\Delete('produkty'))->Where("id_produkt=$id"));
		
		if($result == 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}
