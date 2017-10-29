<?php
class Get{  
    static private $instance;
    
    public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new Get();
        }
        return self::$instance;
    }
	
    public function __get($name) 
    {
        $result = filter_input(INPUT_GET, $name);
        return trim(preg_replace('/[^\p{L}\d]/u', ' ',$result));
    }
    
    
}

class Post{
    static private $instance;
    
    public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new Post();
        }
        return self::$instance;
    }

    public function __get($name) 
    {
        $result = filter_input(INPUT_GET, $name);
        return trim(preg_replace('/[^\p{L}\d]/u', ' ',$result));
    }   
}