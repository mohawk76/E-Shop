<?php

namespace AnvilPHP;

/**
 * GET Wrapper
 */
class Get{ 
	/**
	 * Holds the only Get object
	 * @var Get
	 */
    static private $instance;
    
	private function __construct() {}
	private function __clone() {}
	
	/**
	 * If an object is not created, it creates and returns it. 
	 * Otherwise it returns only reference to this object.
	 * @return Get
	 */
    public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new Get();
        }
        return self::$instance;
    }
	
	public function exist($name)
	{
		return isset($_GET[$name]);
	}

		/**
	 * Reurns value from _GET[$name] or $_GET
	 * @param string $name(optional)
	 * @return mixed
	 */
    public function get($name=NULL) 
    {
		if($name==NULL)
		{
			return $_GET;
		}
		
		if(isset($_GET[$name]))
		{
			return $_GET[$name];
		}
		else
		{
			return NULL;
		}
        
    }
    
	/**
	 * Save value into _GET[$name]
	 * @param string $name
	 * @param mixed $value
	 */
    public function set($name, $value) 
	{
		$_GET[$name] = $value;
	}
	
	/**
	 * Reurns filtered value from _GET[$name]
	 * If it detects illegal characters, it returns to the main page 
	 * @param string $name
	 * @return mixed
	 */
	public function filteredInput($name)
	{
		$result = filter_input(INPUT_GET, $name);
		if(preg_match('/[^\p{L}\d @]/u', $result))
		{
			header("Location: ".HTTP_SERVER);
			die();
		}
        return trim($result);
	}
}