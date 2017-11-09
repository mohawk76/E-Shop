<?php

namespace AnvilPHP;

/**
 * The user object will be included in the session for user authentication
 */
class User {
	
	/**
	 *UserID
	 * @var int
	 */
	private $id;
	
	/**
	 * Username
	 * @var string
	 */
	private $username;
	
	/**
	 * Create user 
	 * @param int $id
	 * @param String $username
	 * @return void
	 */
	public function __construct(int $id, string $username)
	{
		$this->id = $id;
		$this->username = $username;
	}
	
	/**
	 * Returns username
	 * @return String
	 */
	public function getUsername()
	{
		return $this->username;
	}
	
	/**
	 * Returns user ID
	 * @return String
	 */
	public function getUserId() 
	{
		return $this->id;
	}
}

/**
 * Provides access to login and registration
 */
class UserService
{
	/**
	 *Connection with database
	 * @var Database
	 */
    private $db;

	/**
	 * Create UserService
	 * @param Database $db
	 * @return void
	 */
    public function __construct(Database $db) 
    {
       $this->_db = $db;
    }

	/**
	 * User authorization
	 * @param string $login
	 * @param string $password
	 * @return void
	 */
    public function login(string $login, string $password)
    {
        $user = $this->db->sendQuery((new Select())->From('users')->Where('login = "'.$login.'"'));
        
        if (count($user) > 0) 
		{
            if(password_hash($password, PASSWORD_BCRYPT) == $user['password']) 
			{
                Session::getInstance()->user = new User($user['id'], $user['username']);
            }
        }
    }
	
	/**
	 * Check that the user is logged in
	 * @static
	 * @return boolean
	 */
	public static function isLogged()
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
	
	/**
	 * Writes the user to the database
	 * @param string $login
	 * @param string $password
	 * @param string $email
	 * @param string $name
	 * @param string $surname
	 * @param string $postcode
	 * @param string $city
	 * @param string $address
	 * @return void
	 */
	public function register(string $login, string $password, string $email, string $name, string $surname, string $postcode, string $city, string $address)
	{
		if(strlen($login) > 32)
		{
			echo 'Za długi login';
			die();
		}
		else if(strlen($login) < 6)
		{
			echo 'Za krótki login';
			die();
		}
		
		if(strlen($password) < 6)
		{
			echo 'Twoje hasło jest za krótkie"';
			die();
		}
		
		if(filter_input($email, FILTER_VALIDATE_EMAIL))
		{
			echo 'Zły format e-mail\'a"';
			die();
		}
		
		$password = password_hash($password, PASSWORD_BCRYPT);
		
		(new \AnvilPHP\Database\Insert("Users"))->Values(func_get_args());
		
		echo 'Pomyślnie zarejestrowano';
	}
}