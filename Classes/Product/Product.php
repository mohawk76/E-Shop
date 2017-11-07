<?php
    namespace Shop\Product;
	
	/**
	 * Represents the product
	 * @final
	 */
    final class product{
		
		/**
		 *
		 * @var String
		 */
        public $name;
		
		/**
		 * 
		 * @var String
		 */
        public $description;
		
		/**
		 *
		 * @var string
		 */
        public $company;
		
		/**
		 *
		 * @var float
		 */
        public $price;
		
		/**
		 *
		 * @var string Stores path to image
		 */
        public $imagePath;
		
		/**
		 * $var float Holds the percentage discount
		 */
		public $discount;
				
        /**
		 * Create product
		 * @param string $name
		 * @param string $description
		 * @param string $company
		 * @param float $price
		 * @param string $imagePath
		 */
         public function __construct(string $name, string $description, string $company, float $price, string $imagePath, float $discount = 0) {
            $this->name = $name;
            $this->description = $description;
            $this->company = $company;
            $this->price = $price;
            $this->imagePath = $imagePath;
			$this->discount = $discount;
        }
		
        /**
		 * Print product to HTML
		 * @return void
		 */
        public function Show(){
            echo '<pre>';
            printf('Nazwa: '.$this->name.'<br>');
            printf('Opis: '.$this->description.'<br>');
            printf('Producent: '.$this->company.'<br>');
            printf('Cena: '.$this->price.' zł<br>');
            //printf('<img width=150 heigth=150 alt="'.$this->name.'-image" src="'.$this->imagePath.'"/>');
            echo '</pre>';
        }
        
		/**
		 * Converts arrays to product
		 * @param Array $array Values ​​to be converted into products 
		 * @param product $result reference to result
		 * @return boolean Success or failure
		 */
        public static function tryParse($array, &$result)
        {
            if(count($array)!=5)
                return false;
           
            $result = new product($array[0], $array[1], $array[2], $array[3], $array[4]); 
            
            return true;
        }
        
		/**
		 * Checks whether the object is a product
		 * @static
		 * @param unknown $obj
		 * @return boolean
		 */
        public static function isProduct($obj)
        {
            return (get_class($obj)=='product')? TRUE : FALSE; 
        }
   }