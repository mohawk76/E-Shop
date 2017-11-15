<?php

namespace AnvilPHP;

class FileNotExistException extends \Exception{}

class Template implements \AnvilPHP\HTMLGenerators\printerHTML{
	/**
	 * Path to file
	 * @var string
	 */
	protected $file;

	/**
	 * Holds values for template
	 * @var array
	 */	
	protected $values;
	
	/**
	 * Creates Template
	 * @param String $file
	 * @return void
	 */
	public function __construct($file) 
	{
		$this->file = $file;
	}
	
	/**
	 * Set Values in template
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value) {
		$this->values[$name] = $value;
	}
	
	public function __toString() {
		return $this->getResult();
	}
	
	/**
	 * Loading template file html and replaces tags on values
	 * @throws FileExistEception
	 * @return string
	 */
	protected function getResult()
	{
		if(!file_exists($this->file))//Checks whether the file exists
		{
			throw new FileNotExistException("File $this->file doesn't exist.");
		}
		
		$result = file_get_contents($this->file);//Get html code from file
		
		if(isset($this->values))
		{
			foreach ($this->values as $key => $value)//Get key and value from array
			{
				$templateTag = "[@$key]";//Generate tag from $key
				$result = str_replace($templateTag, $value, $result);//Replace a tag with a value
			}
		}
		
		return $result;
	}
	
	/**
	 * Printing template to html
	 * @return void
	 */
	public function printHTML()
	{
		print($this->getResult());//Print HTML code with values
	}
	
	/**
	 * Merge templates
	 * @param array $templates
	 * @param string $separator
	 * @return string
	 * @throws \InvalidArgumentException
	 */
	static function merge($templates, $separator = "\n")
	{
		$output = "";
		
		foreach ($templates as $template)//get single template from array
		{
			if(get_class($template) !== "Template")//Checks whether the object is a template
			{
				throw new \InvalidArgumentException(__METHOD__.' expects instance of template, you passed '.get_class($template));
			}
			$content = $template->printHTML();
			$output .= $content . $separator;//merge template HTML code with separator
		}
		
		return $output;
	}
}