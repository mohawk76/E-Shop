<?php

namespace Shop\Product;
use AnvilPHP\Collection;
use function PHPSTORM_META\type;

/**
 * Contains products
 */
final class productsCollection extends Collection{
    /**
	 * Adding product to collection
	 * @param product $obj
	 * @param String $key(optional)
	 * @throws InvalidArgumentException
	 * @return void
	 */
    public function addItem($obj, $key = null) {
        if (!($obj instanceof product))
        {
            throw new InvalidArgumentException(__METHOD__.' expects instance of products, you passed '.get_class($obj));
        }
        parent::addItem($obj, $key);
    }

	/**
	 * Prints all products to HTML
	 * @return void
	 */
    public function Show()
    {
        foreach($this->items as $item)
        {
            $item->Show();
        }
    }
    
	/**
	 * Searching products in Collection
	 * @param string $productName
	 * @param string $productCompany
	 * @param float $productMinPrice
	 * @param float $productMaxPrice
	 * @return productsCollection
	 */
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
    
	public function getSumPrice()
	{
        $sum = 0;
		foreach($this->items as $item)
		{
            $price = floatval(str_replace(",", ".", $item->price));
			$sum += $price * $item->quantity;
        }
		return $sum;
	}
}
