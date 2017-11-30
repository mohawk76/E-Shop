<?php

namespace Shop\Models;

class Product extends \AnvilPHP\Model
{
	private $select = array("GAME_ID", "Name", "Description", "Price", "ImagePath");
	
	public function getProductByID($id)
	{
		$query = (new \AnvilPHP\Database\Select("Name", "Description", "Price", "ImagePath"))->From('games')->Where("GAME_ID = $id");
		$builder = new \Shop\Product\ProductBuilder($this->database);
		$product = $builder->createProduct($this->database->sendQuery($query)[0]);
		
		return $product;
	}
	
	public function productExist($id)
	{
		$query = (new \AnvilPHP\Database\Select("COUNT(*) as ilosc"))->From('games')->Where("GAME_ID = $id");
		
		if($this->database->sendQuery($query)[0]['ilosc']!=1)
		{
			return false;
		}
		return true;
	}
	
	public function getProducts($limit = 12, $dbOffset = 0)
	{
		$get = \AnvilPHP\Get::getInstance();
		
		$productName = $get->filteredInput('searched');
		$productCategory = $get->filteredInput('category');
		$productPlatform = $get->filteredInput('platform');

	   //Create SearchEngine object and Generating search method's arguments
		$search = new \AnvilPHP\SearchEngine($this->database, "games", $limit);
		$searchArray= array();
	
	   if(!empty($productName))
		{
		   $searchArray[] = ("Name LIKE ".'"%'.$productName.'%"');
		}
		if(!empty($productCategory))
		{
			$searchArray[] =("Category_ID = ".$productCategory);
		}
		if(!empty($productPlatform))
		{
			$searchArray[] = ("Platform_ID = $productPlatform");
		}
		
		//Search and get result
		$result = $search->search($this->select, $searchArray, array(), $dbOffset);
		$products = new \Shop\Product\productsCollection();

		//Parsing search result to product and add to productsCollection
		$builder = new \Shop\Product\ProductBuilder($this->database);
		foreach ($result as $row) 
		{
			$products->addItem($builder->createProduct($row));
		}
		
		return $products;
	}
	
	public function getTotalNumberProducts()
	{
		$get = \AnvilPHP\Get::getInstance();
		
		$productName = $get->filteredInput('searched');
		$productCategory = $get->filteredInput('category');
		$productPlatform = $get->filteredInput('platform');
		
		$searchArray= array();
		
		if(!empty($productName))
		{
		   $searchArray[] = ("Name LIKE ".'"%'.$productName.'%"');
		}
		if(!empty($productCategory))
		{
			$searchArray[] =("Category_ID = ".$productCategory);
		}
		if(!empty($productPlatform))
		{
			$searchArray[] =("Platform_ID = ".$productPlatform);
		}
		
		$result = $this->database->sendQuery((new \AnvilPHP\Database\Select("COUNT(*) as ilosc"))->From("games")->Where($searchArray));
		
		return $result[0]['ilosc'];
	}
	
	public function getProductsFromCart()
	{
		$session = \AnvilPHP\Session::getInstance();
		
		$shopingCart = $session->ShoppingCart->toArray();
		$products = new \Shop\Product\productsCollection();
		$builder = new \Shop\Product\ProductBuilder($this->database);
		
		foreach ($shopingCart as $item)
		{
			$row = $this->database->sendQuery((new \AnvilPHP\Database\Select($this->select))->From('games')->Where("GAME_ID = ".$item['ID']))[0];
			$product = $builder->createProduct($row);
			$product->quantity = $item['Quantity'];
			$products->addItem($product);
		}
		return $products;
	}

	public function addToCart($id, $quantity)
	{
		$session = \AnvilPHP\Session::getInstance();
		
		$finded=$this->isInCart($id);
		
		if($finded===false)
		{
			$product = array(
			'ID' => $id,
			'Quantity' => $quantity
			);
			
			$session->ShoppingCart->addItem($product);
		}
		else
		{
			$session->ShoppingCart->getRef($finded)['Quantity'] += $quantity;
		}
	}
	
	public function changeQuantity($id, $quantity)
	{
		$session = \AnvilPHP\Session::getInstance();
		
		$finded=$this->isInCart($id);
		
		if($finded===false)
		{
			die();
		}
		else
		{
			$session->ShoppingCart->getRef($finded)['Quantity'] = $quantity;
		}
	}
	
	public function deleteFromCart($id)
	{
		$session = \AnvilPHP\Session::getInstance();
		
		$finded=$this->isInCart($id);
		
		if($finded===false)
		{
			return false;
		}
		else
		{
			$session->ShoppingCart->deleteItem($finded);
			return TRUE;
		}
	}
	
	public function clearCart()
	{
		$session = \AnvilPHP\Session::getInstance();
		$session->ShoppingCart->clear();
	}
	
	public function isInCart($id)
	{
		$session = \AnvilPHP\Session::getInstance();
		return $session->ShoppingCart->findValueDim($id,'ID');
	}
	
	public function deleteProductFromDB($id)
	{
		$result = $this->database->sendQuery((new \AnvilPHP\Database\Delete('games'))->Where("GAME_ID = $id"));
		
		if($result>0)
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}
}
