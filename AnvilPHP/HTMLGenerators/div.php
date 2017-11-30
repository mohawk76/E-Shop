<?php

namespace AnvilPHP\HTMLGenerators;

class div extends elementHTML{
	public $elements;
	
	public function __construct() {
		$this->elements = new ElementsCollection();
	}
	
	public function getHTML() {
		$output = "<div ";
		$output .=parent::getHTML();
		$output .= '>';
		
		foreach ($this->elements->toArray() as $element)
		{
			$output .= strval($element);
		}
		return $output;
	}
	
	public function printHTML() {
		print($this->getHTML());
	}
	
	public function __toString() {
		return $this->getHTML();
	}
}
