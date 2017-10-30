<?php
require_once('Database.php');

class User {
	private $id;
	private $username;
	
	public function __construct($id, $username)
	{
		$this->id = $id;
		$this->username = $username;
	}
	
	public function getUsername()
	{
		return $this->username;
	}
	
	public function __toString() 
	{
		return $this->id;
	}
}

class UserService
{
    private $db;

    public function __construct(Database $db) 
    {
       $this->_db = $db;
    }

    public function login($login, $password)
    {
        $user = $this->checkUser($login, $password);
        if ($user) 
		{
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    private function checkUser($login, $password)
    {
        $stmt = $this->db->sendQuery('SELECT * FROM users WHERE login = "'.$login.'"');
        
        if ($stmt->num_rows > 0) 
		{
            $user = $stmt-->fetch_assoc();
            if ($password == $user['password']) 
			{
                return $user;
            }
        }
        return false;
    }
	
	
}