<?php

namespace AnvilPHP\HTMLGenerators\Form;

class Input extends \AnvilPHP\HTMLGenerators\elementHTML
{
   public $label;
   public $type;
   public $name;
   public $value;
   public $newLine;
            
    public function __construct($label = "", $type = "", $name = "", $value = "", bool $newLine = false ) 
    {
        $this->label = $label;
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
        $this->newLine = $newLine;
    }

    public function printHTML()
    {
        print('<label>'.$this->label.'</label>');
        print('<input type="'.$this->type.'" name="'.$this->name.'" value="'.$this->value.'"');
        print('</input>');
        if($this->newLine)
        {
            print('<br>');
        }
    }
}