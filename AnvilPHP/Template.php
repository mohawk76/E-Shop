<?php
require_once 'PrinterHTML.php';

class FileExistEception extends Exception{}

class Template implements printerHTML{
	protected $file;	
	protected $values;
	
	public function __construct($file) 
	{
		$this->file = $file;
	}
	
	public function __set($name, $value) {
		$this->values[$name] = $value;
	}
	
	private function getResult()
	{
		if(!file_exists($this->file))
		{
			throw new FileExistEception("File $this->file doesn't exist.");
		}
		
		$result = file_get_contents($this->file);
		
		foreach ($this->values as $key => $value)
		{
			$templateTag = "[@$key]";
			$result = str_replace($templateTag, $value, $result);
		}
		
		return $result;
	}
	
	public function printHTML()
	{
		print($this->getResult());
	}
}