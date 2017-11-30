<?php

namespace Shop\Models;

class Home extends \AnvilPHP\Model
{
	public function getSpanCategories()
	{
		$categories = $this->database->sendQuery('SELECT Name, Category_ID FROM categories;');
		$result = "";
		
		foreach($categories as $category) 
        {  
			$element = new \AnvilPHP\HTMLGenerators\span($category['Name']); 
			$element->id = $category['Category_ID'];
			$element->class = "selectOption";
			$result .= $element;
		}
		
		return $result;
	}
	
	public function getLinkPlatform($url)
	{
		$platforms = $this->database->sendQuery('SELECT Name, Platform_ID FROM platform;');
		$result = array();
		
		$defualt = new \AnvilPHP\HTMLGenerators\a($url.'?platform=', "Wszystkie platformy");
		$defualt->class = "subOpcja";
		
		$result[] = $defualt;
		
		foreach($platforms as $platform) 
        {  
			$element = new \AnvilPHP\HTMLGenerators\a($url.'?platform='.$platform['Platform_ID'], $platform['Name']); 
			$element->class = "subOpcja";
			$result[] = $element;
		}
		
		return $result;
	}
}
