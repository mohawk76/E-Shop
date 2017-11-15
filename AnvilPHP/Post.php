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
	
	private function __construct() {}
	private function __clone() {}
	
	/**
	 * If an object is not created, it creates and returns it. 
	 * Otherwise it returns only reference to this object.
	 * @return Post
	 */
	public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new Post();
        }
        return self::$instance;
    }
	
	public function exist()
	{
		return isset($_GET[$name]);
	}

	/**
	 * Reurns value from _POST[$name]
	 * @param string $name
	 * @return mixed
	 */
    public function get($name=NULL) 
    {
		if($name==NULL)
		{
			return $_POST;
		}
		
		if(isset($_POST[$name]))
		{
			return $_POST[$name];
		}
		else
		{
			return NULL;
		}
        
    }  
	
	/**
	 * Save value into _POST[$name]
	 * @param string $name
	 * @param mixed $value
	 */
	public function set($name, $value) 
	{
		$_POST[$name] = $value;
	}
	
	/**
	 * Reurns filtered value from _POST[$name]
	 * If it detects illegal characters, it returns to the main page 
	 * @param string $name
	 * @return mixed
	 */
	public function filteredInput($name)
	{
		$result = filter_input(INPUT_POST, $name);
		if(preg_match('/[^\p{L}\d @]/u', $result))
		{
			header("Location: ".HTTP_SERVER);
			die();
		}
        return trim($result);
	}
}