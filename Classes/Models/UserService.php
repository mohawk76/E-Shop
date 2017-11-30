<?php

namespace Shop\Models;

class UserService extends \AnvilPHP\Model
{
	/**
	 * Check that the user is logged in
	 * @return boolean
	 */
	public static function isLogged()
	{
		if(isset(\AnvilPHP\Session::getInstance()->user))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function deleteUserSession()
	{
		\AnvilPHP\Session::getInstance()->destroy();
	}

		public function getUser(string $login)
	{
		return $this->database->sendQuery((new \AnvilPHP\Database\Select())->From('users')->Where('`E-mail` = "'.$login.'"'));
	}
	
	public function addUser($userData)
	{
		$query = (new \AnvilPHP\Database\Insert("Users (`E-mail`, `Password`, `Birthdate`)"))->Values("\"".$userData['e-mail']."\"", "\"".$userData['passwd']."\"", ("\"".$userData['year']."-".$userData['month']."-".$userData['day']."\""));
		
		return $this->database->sendQuery($query);
	}
	
	public function deleteUser($id)
	{
		$result = $this->database->sendQuery((new \AnvilPHP\Database\Delete('users'))->Where("id=$id"));
		
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
