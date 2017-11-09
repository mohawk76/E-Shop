<?php

namespace AnvilPHP;

/**
 * Wrapper for SESSION
 */
class Session{
    /**
	 * Determines the time after the session will expire
	 * @var int
	 */
    static private $expiryTime;
	
	/**
	 * The only class object
	 * @var Session 
	 */
    private static $instance;
    
    private function __construct() {}
    private function __clone() {}

	/**
	 * 
	 * @param int $expiryTime(optional)
	 * @return Session
	 */
    static public function getInstance($expiryTime = 1800)
    {
        if (!isset(self::$instance)) 
        {
            self::$instance = new Session();
        }
        
        self::$instance->start($expiryTime);
        
        if(self::$instance->isExpired())
        {
            self::$instance->destroy();
            self::$instance->start($expiryTime);
        }
        else
        {
            $_SESSION["LAST_ACTIVITY"] = time();
        }
        
        return self::$instance;
    }
    
	/**
	 * 
	 * @param int $expiryTime
	 * @return void
	 */
    public function start($expiryTime)
    {
        if (!$this->isActive())
        {
            session_start();
            
            if (!isset($_SESSION["LAST_ACTIVITY"])) 
            {
                $_SESSION["LAST_ACTIVITY"] = time();
            }
            
            self::$expiryTime = $expiryTime;
            
            if (!isset($_SESSION['CREATED'])) 
            {
                session_unset();
                $_SESSION['CREATED'] = time();
            } 
            else if (time() - $_SESSION['CREATED'] > 600)
            {
                session_regenerate_id(true);
                $_SESSION['CREATED'] = time();  
            }
        }
    }

	/**
	 * 
	 * @param String $key
	 * @return mixed
	 */
    public function __get($key)
    {
         return isset($_SESSION[$key])? $_SESSION[$key] : NULL;
    }
    
	/**
	 * 
	 * @param String $key
	 * @return ref to mixed
	 */
    public function &getRef($key)
    {
        if (isset($_SESSION[$key])) 
        {
            $result = & $_SESSION[$key];
        }
        else 
        {
            $result = NULL;
        }
        return $result;
    }

	/**
	 * 
	 * @param String $key
	 * @param mixed $value
	 * @throws \InvalidArgumentException
	 * @return void
	 */
    public function __set($key, $value)
    {
        if(!isset($_SESSION[$key]))
        {
            $_SESSION[$key] = $value;
        }
        else
        {
			throw new \InvalidArgumentException("The key is in use");
        }
    }
    
	/**
	 * 
	 * @param string $name
	 * @return boolean
	 */
    public function __isset($name) 
    {
        return isset($_SESSION[$name]);
    }
    
	/**
	 * 
	 * @param String $name
	 * @return void
	 */
    public function __unset($name) 
    {
        unset($_SESSION[$name]);
    }
    
	/**
	 * Destroys Session
	 * @return boolean
	 */
    public function destroy()
    {
        if ($this->isActive())
        {
            session_unset();
            session_destroy();    
            return true;
        }
        return false;
    }

	/**
	 * Checks if the session has expired 
	 * @return boolean
	 */
    private function isExpired()
    {
        if ((isset($_SESSION['LAST_ACTIVITY'])) && (time() - $_SESSION['LAST_ACTIVITY'] > self::$expiryTime))
        {
            return TRUE;
        }
        return FALSE;
    }
    
	/**
	 * Checks if the session is active
	 * @return boolean
	 */
    private function isActive()
    {
         return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
    }
}