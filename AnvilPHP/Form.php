<?php
require_once('PrinterHTML.php');

class formInput implements printerHTML
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

class formSelect implements printerHTML
{
   public $label;
   public $name;
   public $value;
   public $newLine;
   public $options = array();
    
    public function __construct() {
        
    }
    
    public function printHTML()
    {

    }
}

class selectOption implements printerHTML
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

class formBuilder implements printerHTML
{
   public $action;
   public $method;
   public $inputs = array();
    
    public function printHTML() {
        
    }
}


