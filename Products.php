<?php
    require_once('AnvilPHP/Collection.php');
    require_once('AnvilPHP/PrinterHTML.php');
	
    class product{
        public $name;
        public $description;
        public $company;
        public $price;
        public $imagePath;
        
         public function __construct(string $name, string $description, string $company, float $price, string $imagePath) {
            $this->name = $name;
            $this->description = $description;
            $this->company = $company;
            $this->price = $price;
            $this->imagePath = $imagePath;
        }
        
        public function Show(){
            echo '<pre>';
            printf('Nazwa: '.$this->name.'<br>');
            printf('Opis: '.$this->description.'<br>');
            printf('Producent: '.$this->company.'<br>');
            printf('Cena: '.$this->price.' zł<br>');
            //printf('<img width=150 heigth=150 alt="'.$this->name.'-image" src="'.$this->imagePath.'"/>');
            echo '</pre>';
        }
        
        public static function tryParse($array, &$result)
        {
            if(count($array)!=5)
                return false;
           
            $result = new product($array[0], $array[1], $array[2], $array[3], $array[4]); 
            
            return true;
        }
        
        public static function isProduct($obj)
        {
            return (get_class($obj)=='product')? TRUE : FALSE; 
        }
   }

class productsCollection extends Collection{
    
    public function addItem($obj, int $key = null) {
        if (!($obj instanceof product))
        {
            throw new InvalidArgumentException(__METHOD__.' expects instance of ChildOfGuaranteed, you passed '.get_class($obj));
        }
        parent::addItem($obj, $key);
    }

    public function Show()
    {
        foreach($this->items as $item)
        {
            $item->Show();
        }
    }
    
    public function findProducts(string $productName, string $productCompany,
            float $productMinPrice, float $productMaxPrice)
    {
        $result = new productsCollection();
        
        foreach($this->items as $item)
        {
            $found = true; 
            if(!empty($productName) && (strpos(strtolower($item->name), strtolower($productName)) === false))
            {
               $found = false; 
            }
                
            if($found && (!empty($productCompany) && (strpos(strtolower($item->company), strtolower($productCompany)) === false)))
            {
                $found = false;  
            }
                
            if($found && (!empty($productMinPrice) && $item->price<$productMinPrice))
            {
                $found = false;  
            }
                
            if($found && (!empty($productMaxPrice) && $item->price>$productMaxPrice))
            {
                $found = false;  
            }
                
            if($found)
            {
                $result->addItem($item);
            }
        }
        
        return $result;
    }
    
}