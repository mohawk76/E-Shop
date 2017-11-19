<?php

namespace AnvilPHP\HTMLGenerators\FormHTML;

class Input extends \AnvilPHP\HTMLGenerators\elementHTML
{
   public $label;
   public $type;
   public $name;
   public $value;
   public $newLine = true;
            
    public function __construct($type = "", $name = "") 
    {
        $this->type = $type;
        $this->name = $name;
    }
	
	public function getHTML() 
	{
		$output = "";
		
		if(isset($this->label))
		{
			$output .= "<label>$this->label.</label>";
		}
		
		$output .= "<input type=\"$this->type\" ";
		
		$output .= "name=\"$this->name\ ";
		if(isset($this->value))
		{
			$output .= "value=\"$this->value\" ";
		}
		
		$output .= parent::getHTML();
		
		$output .= "</input>";
		
		if($this->newLine)
        {
           $output .= "<br>";
        }
		
		return $output."\n";
		
	}

	public function printHTML()
    {
        print($this->getHTML());   
    }
}