<?php

namespace Shop\Views;

class Product extends \AnvilPHP\View
{
	public function __construct() 
	{
		
	}
	
	public function loadProducts(\Shop\Product\productsCollection $products, $url, $templatePath)
	{
		if(!$products->isEmpty())
		{
			$result = "";
			foreach ($products->toArray() as $displayed)
			{
				$generatedUrl = str_replace('{id}', $displayed->id, $url);
				$template = (new \Shop\Product\ProductTemplate($templatePath))->setProduct($displayed);
				$template->url = $generatedUrl;
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
