<?php

namespace AnvilPHP\HTMLGenerators;

class a extends \AnvilPHP\HTMLGenerators\elementHTML {
	public $dowloand;
	public $href;
	public $rel;
	public $target;
	public $type;
	public $text;


	public function __construct($url, $text) {
		$this->href = $url;
		$this->text = $text;
	}
	
	public function getHTML()
	{
		$result = "<a ";
		
		$result .= parent::getHTML().' ';
		
		if(isset($this->rel))
		{
			$result .= "rel=\"$this->rel\" ";
		}
		
		$result .= "href=\"$this->href\" ";
		
		if($this->dowloand)
		{
			$result .= 'download ';
		}
		if(isset($this->target))
		{
			$result .= "target=\"$this->target\" ";
		}
		if(isset($this->type))
		{
			$result .= "type=\"$this->type\" ";
		}
		$result .= ">$this->text</a>";
		
		return $result;
	}

	public function printHTML() {
		print($this->getHTML());
	}
	
	public function __toString() {
		return $this->getHTML();
	}
}
