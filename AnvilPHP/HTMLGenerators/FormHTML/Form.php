<?php

namespace AnvilPHP\HTMLGenerators\FormHTML;

class Form extends \AnvilPHP\HTMLGenerators\elementHTML
{
   public $action;
   public $method;
   public $inputs;
    
   public function __construct() {
	   $this->inputs = new \AnvilPHP\HTMLGenerators\ElementsCollection();
   }
   
    public function printHTML() {
        
    }
}


