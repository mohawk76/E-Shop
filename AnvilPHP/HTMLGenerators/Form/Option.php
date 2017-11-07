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
    
    public function printHTML($selected="")
    {
        print('<option value="'.$this->value.'" ');
        if($selected== $this->value)
            print('selected="selected" ');
        print('>'.$this->text.'</option>');
    }
}