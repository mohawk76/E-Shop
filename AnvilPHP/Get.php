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
	
	/**
	 * Reurns value from _GET[$name]
	 * @param string $name
	 * @return any type
	 */
    public function __get($name) 
    {
        $result = filter_input(INPUT_GET, $name);
        return $result;
    }
    
	/**
	 * Save value into _GET[$name]
	 * @param string $name
	 * @param any type $value
	 */
    public function __set($name, $value) 
	{
		$_GET[$name] = $value;
	}
	
	/**
	 * Reurns filtered value from _GET[$name]
	 * If it detects illegal characters, it returns to the main page 
	 * @param string $name
	 * @return any type
	 */
	public function filteredInput($name)
	{
		$result = filter_input(INPUT_GET, $name);
		if(preg_match('/[^\p{L}\d @]/u', $result))
		{
			header("Location: index.php");
			die();
		}
        return trim($result);
	}
}