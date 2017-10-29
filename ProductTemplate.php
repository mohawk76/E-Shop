<?php

require_once 'AnvilPHP/Template.php';
require_once 'Products.php';

class ProductTemplate extends Template{
	
	public function __set($name, $value) {}
	
	public function __construct($file) 
	{
		parent::__construct($file);	
	}
	
	public function set(product $product)
	{
		$this->values = $product;
		return $this;
	}
}
