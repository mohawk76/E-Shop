<?php

namespace Shop\Views;

class Product extends \AnvilPHP\View
{
	public function __construct() 
	{
		
	}
	
	public function loadProducts(\Shop\Product\productsCollection $products, $templatePath)
	{
		if(!$products->isEmpty())
		{
			$result = "";
			foreach ($products->toArray() as $displayed)
			{					
				$url = str_replace('{id}', $displayed->id, $this->generateUrl('addToCart', array('id' => '{id}')));
				$template = (new \Shop\Product\ProductTemplate($templatePath))->setProduct($displayed);
				$template->url = $url;
				$result .= $template."\n";
			}
			return $result;
		}
		else
		{
			return 'Nie znaleziono przedmiotów<br>';
		}	
	}
}
