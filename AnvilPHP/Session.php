<?php

namespace AnvilPHP;

class Session{
    
    static private $expiryTime;
    private static $instance;
    
    private function __construct() {}
    private function __clone() {}

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
        
        return $this->sessionState;
    }

    public function __get($key)
    {
         return isset($_SESSION[$key])? $_SESSION[$key] : NULL;
    }
    
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

        public function __set($key, $value)
    {
        if(!isset($_SESSION[$key]))
        {
            $_SESSION[$key] = $value;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function __isset($name) 
    {
        return isset($_SESSION[$name]);
    }
    
    public function __unset($name) 
    {
        unset($_SESSION[$name]);
    }
    
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

    private function isExpired()
    {
        if ((isset($_SESSION['LAST_ACTIVITY'])) && (time() - $_SESSION['LAST_ACTIVITY'] > self::$expiryTime))
        {
            return TRUE;
        }
        return FALSE;
    }
    
    private function isActive()
    {
         return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
    }
}