<?php

namespace AnvilPHP\HTMLGenerators;

class ElementsCollection extends \AnvilPHP\Collection implements printerHTML{
	
	public function addItem($obj, $key = null) {
		if(is_subclass_of($obj, 'elementHTML'))
		{
			parent::addItem($obj, $key);
		}
		else 
		{
			throw new InvalidArgumentException(__METHOD__.' expects instance of elementHTML, you passed '.get_class($obj));
		}
	}
	
	public function printHTML() {
		foreach($this->items as $element)
		{
			$element->printHTML();
		}
	}
	
	public function getCollectionString()
	{
		$output = "";
		foreach($this->items as $element)
		{
			$output .= strval($element)."\n";
		}
		return $output;
	}
	
	public function __toString() {
		return $this->getCollectionString();
	}
}
