<?php

namespace Shop\Models;

class Home extends \AnvilPHP\Model
{
	public function getCategories()
	{
		$categories = $this->database->sendQuery('SELECT Nazwa, id_kategorii FROM kategorie;');
		$result = "";
		
		foreach($categories as $category) 
        {  
			$result .= (new \AnvilPHP\HTMLGenerators\Form\Option($category['Nazwa'], $category['id_kategorii']))->getOption(\AnvilPHP\Get::getInstance()->filteredInput('category'))."\n";
		}
		
		return $result;
	}
	
	public function loadProducts()
	{
		$get = \AnvilPHP\Get::getInstance();
		
		$productName = $get->filteredInput('searched');
		$productCategory = $get->filteredInput('category');

	   //Create SearchEngine object and Generating search method's arguments
		$search = new \AnvilPHP\SearchEngine($this->database, "produkty");
		$searchArray= array();
	
	   if(!empty($productName))
		{
		   $searchArray[] = ("Nazwa LIKE ".'"%'.$productName.'%"');
		}
		if(!empty($productCategory))
		{
			$searchArray[] =("id_kategorii = ".$productCategory);
		}


		$select = array("Nazwa", "Opis", "Cena", "id_producent", "ID_Image");

		//Search and get result
		$result = $search->search($select, $searchArray);
		$products = new \Shop\Product\productsCollection();

		//Parsing search result to product and add to productsCollection
		$builder = new \Shop\Product\ProductBuilder($this->database);
		foreach ($result as $row) 
		{
			$products->addItem($builder->createProduct($row));
		}

		if(!$products->isEmpty())
		{
			$result = "";
			foreach ($products->toArray() as $displayed)
			{
				$result .= (new \Shop\Product\ProductTemplate("Templates/productTemplate.html"))->set($displayed)."\n";
			}
			return $result;
		}
		else
		{
			return 'Nie znaleziono przedmiotu<br>';
		}	
	}
}
