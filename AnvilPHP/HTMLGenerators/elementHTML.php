<?php

namespace AnvilPHP\HTMLGenerators;

abstract class elementHTML implements printerHTML, GetHTML {
    public $id;
    public $class;
	
    public function printHTML()
	{
		
	}
	
	public function getHTML() 
	{
		$output = "";
		
		if(isset($this->id))
		{
			$output .= "id=\"$this->id\" ";
		}
		
		if(isset($this->class))
		{
			$output .= "class=\"$this->class\" ";
		}
		
		return $output;
	}
			
}