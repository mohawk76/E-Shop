<?php

namespace Shop\Product;

/**
 * Template specialized for products objects
 */
class ProductTemplate extends \AnvilPHP\Template{
	
	private $product;
	
	/**
	 * 
	 * @param String $file
	 */
	public function __construct($file) 
	{
		parent::__construct($file);	
	}
	
	public function getResult()
	{
		$result = parent::getResult();
		foreach ($this->product as $key => $value)//Get key and value from product
		{
			$templateTag = "[@$key]";//Generate tag from $key
			$result = str_replace($templateTag, $value, $result);//Replace a tag with a value
		}
		
		return $result;
	}

	/**
	 * @param product $product
	 * @return $this
	 */
	public function setProduct(product $product)
	{
		if($product->discount!=0)
		{
			$product->oldPrice = '<s>'.($product->oldPrice).'</s>';
			$product->discount = 'Zniżka: '.($product->discount*100).'%';
		}
		else 
		{
			$product->discount = "";
			$product->oldPrice = "";
		}
		$this->product = $product;
		
		return $this;
	}
	
	
}
