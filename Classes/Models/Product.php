<?php

namespace Shop\Models;

class Product extends \AnvilPHP\Model
{
	public function getProductByID($id)
	{
		$query = (new \AnvilPHP\Database\Select("Nazwa", "Opis", "Cena", "id_producent", "ID_Image"))->From('produkty')->Where("id_produkt = $id");
		$builder = new \Shop\Product\ProductBuilder($this->database);
		$product = $builder->createProduct($this->database->sendQuery($query)[0]);
		
		return $product;
	}
	
	public function productExist($id)
	{
		$query = (new \AnvilPHP\Database\Select("COUNT(*) as ilosc"))->From('produkty')->Where("id_produkt = $id");
		
		if($this->database->sendQuery($query)[0]['ilosc']!=1)
		{
			return false;
		}
		return true;
	}
	
	public function loadProducts($limit = 12, $dbOffset = 0)
	{
		$get = \AnvilPHP\Get::getInstance();
		
		$productName = $get->filteredInput('searched');
		$productCategory = $get->filteredInput('category');

	   //Create SearchEngine object and Generating search method's arguments
		$search = new \AnvilPHP\SearchEngine($this->database, "produkty", $limit);
		$searchArray= array();
	
	   if(!empty($productName))
		{
		   $searchArray[] = ("Nazwa LIKE ".'"%'.$productName.'%"');
		}
		if(!empty($productCategory))
		{
			$searchArray[] =("id_kategorii = ".$productCategory);
		}


		$select = array("id_produkt", "Nazwa", "Opis", "Cena", "id_producent", "ID_Image");

		//Search and get result
		$result = $search->search($select, $searchArray, array(), $dbOffset);
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
		
		$searchArray= array();
		
		if(!empty($productName))
		{
		   $searchArray[] = ("Nazwa LIKE ".'"%'.$productName.'%"');
		}
		if(!empty($productCategory))
		{
			$searchArray[] =("id_kategorii = ".$productCategory);
		}
		
		$result = $this->database->sendQuery((new \AnvilPHP\Database\Select("COUNT(*) as ilosc"))->From("produkty")->Where($searchArray));
		
		return $result[0]['ilosc'];
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
}
