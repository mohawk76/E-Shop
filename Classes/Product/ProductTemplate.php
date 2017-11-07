<?php

namespace Shop\Product;

/**
 * Template specialized for products objects
 */
class ProductTemplate extends \AnvilPHP\Template{
	
	public function __set($name, $value) {}
	
	/**
	 * 
	 * @param String $file
	 */
	public function __construct($file) 
	{
		parent::__construct($file);	
	}
	
	/**
	 * 
	 * @param product $product
	 * @return $this
	 */
	public function set(product $product)
	{
		$this->values = $product;
		return $this;
	}
}
