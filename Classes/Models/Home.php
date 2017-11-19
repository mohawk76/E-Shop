<?php

namespace Shop\Models;

class Home extends \AnvilPHP\Model
{
	public function getSpanCategories()
	{
		$categories = $this->database->sendQuery('SELECT Nazwa, id_kategorii FROM kategorie;');
		$result = "";
		
		foreach($categories as $category) 
        {  
			$element = new \AnvilPHP\HTMLGenerators\span($category['Nazwa']); 
			$element->id = $category['id_kategorii'];
			$element->class = "selectOption";
			$result .= $element;
		}
		
		return $result;
	}
	
	public function getLinkCategories($url)
	{
		$categories = $this->database->sendQuery('SELECT Nazwa, id_kategorii FROM kategorie;');
		$result = "";
		
		foreach($categories as $category) 
        {  
			$element = new \AnvilPHP\HTMLGenerators\a($url.'?category='.$category['id_kategorii'], $category['Nazwa']); 
			$element->class = "subOpcja";
			$result .= $element;
		}
		
		return $result;
	}
}
