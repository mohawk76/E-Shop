<?php
    namespace Shop\Product;
	
	/**
	 * Represents the product
	 * @final
	 */
    final class product{
		/**
		 * @var int
		 */
		public $id;

		/**
		 * @var String
		 */
        public $name;
		
		/**
		 * @var String
		 */
        public $description;
		
		/**
		 * @var float
		 */
        public $price;
		
		/**
		 * @var string Stores path to image
		 */
        public $imagePath;
		
		/**
		 * @var string Stores path to detailed description
		 */
		public $descriptionPath;

		/**
		 * $var float Holds the percentage discount
		 */
		public $discount;
		
		/**
		 * @var float Holds previous price before discount
		 */
		public $oldPrice;

		/**
		 *
		 * @var int holds product quantity in shoppingCart
		 */
		public $quantity;

		/**
		 * Create product
		 * @param string $name
		 * @param string $description
		 * @param float $price
		 * @param string $imagePath
		 */
         public function __construct(int $id, string $name, string $description, float $price, string $imagePath, float $discount = 0) {
			$this->id = $id;
			$this->name = $name;
            $this->description = $description;
			$this->oldPrice = number_format($price, 2, ',', ' ');
            $this->price = number_format(($price-($price*$discount)), 2, ',', ' ');
            $this->imagePath = DIR_IMAGES.$imagePath;
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