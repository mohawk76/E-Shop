<?php

namespace AnvilPHP\HTMLGenerators\Form;

class Option extends \AnvilPHP\HTMLGenerators\elementHTML
{
   public $text;
   public $value;
    
    public function __construct(string $text="", string $value="") {
        $this->text = $text;
        $this->value = $value;
    }
	
	public function getOption($selected="")
	{
		$result = '<option value="'.$this->value.'" ';
		
        if($selected== $this->value)
            $result .= 'selected="selected" ';
		
        $result .= '>'.$this->text.'</option>';
		
		return $result;
	}


	public function printHTML($selected="")
    {
        print(getOption($selected));
    }
}