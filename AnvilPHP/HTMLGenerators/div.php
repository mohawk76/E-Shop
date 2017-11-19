<?php

namespace AnvilPHP\HTMLGenerators;

class div extends elementHTML{
	public $elements;
	
	public function __construct() {
		$this->elements = new ElementsCollection();
	}
	
	
}
