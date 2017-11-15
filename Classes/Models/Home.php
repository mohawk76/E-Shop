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
}
