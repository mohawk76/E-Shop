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