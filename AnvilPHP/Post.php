<?php

namespace AnvilPHP;

/**
 * POST Wrapper
 */
class Post{
	/**
	 * Holds the only Post object
	 * @var Post
	 */
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
        $result = filter_input(INPUT_POST, $name);
        return $result;
    }  
	
	public function __set($name, $value) 
	{
		$_POST[$name] = $value;
	}
	
	public function filteredInput($name)
	{
		$result = filter_input(INPUT_POST, $name);
		if(preg_match('/[^\p{L}\d @]/u', $result))
		{
			header("Location: index.php");
			die();
		}
        return trim($result);
	}
}