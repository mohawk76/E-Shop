<?php

namespace AnvilPHP;

class Router
{
	/**
	 * @var String store url 
	 */
    private $url;
	/**
	 * @var RouteCollecion store url 
	 */
    private static $collection;
	/**
	 * @var String store path to controller
	 */
    private $file;
	/**
	 * @var String store class name 
	 */
    private $class;
	/**
	 * @var store method name
	 */
    private $method;
 
	/**
	 * 
	 * @param String $url
	 * @param RouteCollection $collection
	 */
    public function __construct($url, $collection = null)
    {
        if ($collection != null) {
            Router::$collection = $collection;
        }
        $url=explode('?', $url);
        $this->url = $url[0];
    }
 
	/**
     * @param array $collection
     */
    public static function setCollection($collection)
    {
        Router::$collection = $collection;
    }
	
	/**
	 * 
	 * @return RouteCollection
	 */
    public static function getCollection()
    {
        return Router::$collection;
    }
	
	/**
	 * 
	 * @param String $class
	 */
    public function setClass($class)
    {
        $this->class = $class;
    }
	
	/**
	 * 
	 * @return String
	 */
    public function getClass()
    {
        return $this->class;
    }
	
	/**
	 * 
	 * @param String $file
	 */
    public function setFile($file)
    {
        $this->file = $file;
    }
 
	/**
	 * 
	 * @return string
	 */
    public function getFile()
    {
        return $this->file;
    }
 
	/**
	 * 
	 * @param String $method
	 */
    public function setMethod($method)
    {
        $this->method = $method;
    }
 
	/**
	 * 
	 * @return String
	 */
    public function getMethod()
    {
        return $this->method;
    }
 
	/**
	 * 
	 * @param String $url
	 */
    public function setUrl($url)
    {
        $this->url = $url;
    }
 
    /**
     * @return String
     */
    public function getUrl()
    {
        return $this->url;
    }
 
	/**
	 * 
	 * @param Route $route
	 * @return boolean
	 */
    private function matchRoute($route)
    {
        $params = array();
        $key_params = array_keys($route->getParams());
        $value_params = $route->getParams();
        foreach ($key_params as $key) {
            $params['<' . $key . '>'] = $value_params[$key];
        }
        $url = $route->getPath();
		
        $url = str_replace(array_keys($params), $params, $url);
		
        $url = preg_replace('/<\w+>/', '.*', $url);
        
        preg_match("#^$url$#", $this->url, $results);
        if ($results) {
            $this->url=str_replace(array($this->strlcs($url, $this->url)), array(''), $this->url);
            $this->file = $route->getFile();
            $this->class = $route->getClass();
            $this->method = $route->getMethod();
            return true;
        }
        return false;
    }
 
	/**
	 * 
	 * @return boolean
	 */
    public function run()
    {
        foreach (Router::$collection->toArray() as $route) {
            if ($this->matchRoute($route)) {
                $this->setGetData($route);
                return true;
            }
        }
        return false;
    }
	
	/**
	 * 
	 * @param Route $route
	 */
    private function setGetData($route)
    {
        $routePath=str_replace(array('(', ')'), array('', ''), $route->getPath());
        $trim=explode('<', $routePath);
        $parsed_url=str_replace(array(HTTP_SERVER), array(''), $this->url);
        $parsed_url=preg_replace("#$trim[0]#", '', $parsed_url, 1);
		
        foreach ($route->getParams() as $key => $param) {
            if(!empty($parsed_url[0]) && $parsed_url[0]=='/') {
                $parsed_url = substr($parsed_url, 1);
            }
            preg_match("#$param#", $parsed_url, $results);
            if (!empty($results[0])) {
                $_GET[$key] = $results[0];
                $temp_url=explode($results[0], $parsed_url, 2);
				
                $parsed_url=$temp_url[1];
            }
        }
        foreach ($route->getDefaults() as $key => $default) 
		{
            if (!isset($_GET[$key])) 
			{
                $_GET[$key] = $default;
            }
        }
    }
 
	/**
	 * 
	 * @param string $str1
	 * @param string $str2
	 * @return string|array
	 */
    private function strlcs($str1, $str2){
        $str1Len = strlen($str1);
        $str2Len = strlen($str2);
        $ret = array();
 
        if($str1Len == 0 || $str2Len == 0)
		{
			return $ret; //no similarities
		}
		
        $CSL = array(); //Common Sequence Length array
        $intLargestSize = 0;
 
		//initialize the CSL array to assume there are no similarities
        for($i=0; $i<$str1Len; $i++)
		{
            $CSL[$i] = array();
            for($j=0; $j<$str2Len; $j++)
			{
                $CSL[$i][$j] = 0;
            }
        }
 
        for($i=0; $i<$str1Len; $i++)
		{
            for($j=0; $j<$str2Len; $j++)
			{
				//check every combination of characters
                if( $str1[$i] == $str2[$j] )
				{
					//these are the same in both strings
                    if($i == 0 || $j == 0)
					{
						//it's the first character, so it's clearly only 1 character long
                        $CSL[$i][$j] = 1;
					}	
                    else
					{
						//it's one character longer than the string from the previous character
                        $CSL[$i][$j] = $CSL[$i-1][$j-1] + 1;
					}
                    if( $CSL[$i][$j] > $intLargestSize )
					{
						//remember this as the largest
                        $intLargestSize = $CSL[$i][$j];
						//wipe any previous results
                        $ret = array();
						//and then fall through to remember this new value
                    }
                    if( $CSL[$i][$j] == $intLargestSize )
					{
						//remember the largest string(s)
                        $ret[] = substr($str1, $i-$intLargestSize+1, $intLargestSize);
					}		
				}
			//else, $CSL should be set to 0, which it was already initialized to
            }
        }
		//return the list of matches
        if(isset($ret[0]))
		{
            return $ret[0];
        } 
		else 
		{
            return '';
        }
    }
} 