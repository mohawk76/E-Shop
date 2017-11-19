<?php

namespace AnvilPHP\HTMLGenerators;

class span extends elementHTML 
{
	public $text;
	
	public function __construct($text) {
		$this->text = $text;
	}
	
	public function getHTML() {
		$output = "<span ";
		$output .= parent::getHTML();
		$output .= ">$this->text</span>";
		
		return $output;
	}
	
	public function printHTML() 
	{
		print($this->getHTML());
	}
	
	public function __toString() 
	{
		return $this->getHTML();
	}
}
