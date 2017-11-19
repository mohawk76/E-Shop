<?php

namespace AnvilPHP\HTMLGenerators\FormHTML;

class Select extends \AnvilPHP\HTMLGenerators\elementHTML
{
   public $label;
   public $name;
   public $value;
   public $newLine;
   public $options;
    
    public function __construct() {
        $this->options = new \AnvilPHP\HTMLGenerators\ElementsCollection();
    }
    
    public function printHTML()
    {

    }
}