<?php

namespace AnvilPHP;

class Route
{
	/**
	 *
	 * @var String path URL
	 */
    private $path;
	
	/**
	 *
	 * @var String path to controller 
	 */
    private $file;
	
	/**
	 *
	 * @var String class name
	 */
    private $class;
	
	/**
	 *
	 * @var String method name
	 */
    private $method;
	
	/**
	 *
	 * @var Array contains default values for parameters
	 */
    private $defaults;
	
	/**
	 *
	 * @var Array contains rules processing parameters
	 */
    private $params;
 
	/**
	 * 
	 * @param String $path
	 * @param Array $config
	 * @param Array $params
	 * @param Array $defaults
	 */
    public function __construct($path, $config, $params = array(), $defaults = array())
    {
        $this->path = $path;
        $this->file = $config['file'];
        $this->method = $config['method'];
        $this->class = $config['class'];
        $this->setParams($params);
        $this->setDefaults($defaults);
    }

	/**
	 * 
	 * @param String $controller
	 */
    public function setFile($controller)
    {
        $this->file = $controller;
    }

	/**
	 * 
	 * @String type
	 */
    public function getFile()
    {
        return $this->file;
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
	 * @param Array $defaults
	 */
    public function setDefaults($defaults)
    {
        $this->defaults = $defaults;
    }

	/**
	 * 
	 * @return Array
	 */
    public function getDefaults()
    {
        return $this->defaults;
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
	 * @param Array $params
	 */
    public function setParams($params)
    {
        $this->params = $params;
    }

	/**
	 * 
	 * @return Array
	 */
    public function getParams()
    {
        return $this->params;
    }

	/**
	 * 
	 * @param String $path
	 */
    public function setPath($path)
    {
        $this->path = HTTP_SERVER . $path;
    }

	/**
	 * 
	 * @return String
	 */
    public function getPath()
    {
        return $this->path;
    }
	
	/**
	 * 
	 * @param String $data
	 * @return String
	 */
    public function generateUrl($data)
    {
        if (is_array($data)) {
            $key_data = array_keys($data);
            foreach ($key_data as $key) {
                $data2['<' . $key . '>'] = $data[$key];
            }
            $url = str_replace(array('?', '(', ')'), array('', '', ''), $this->path);
            return str_replace(array_keys($data2), $data2, $url);
        } else {
            return str_replace(array('?', '(', ')'), array('', '', ''), $this->path);
        }
    }
} 
