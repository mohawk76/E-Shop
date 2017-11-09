<?php

namespace AnvilPHP;

/**
 * Can contains values mixed
 */
class Collection 
{
	/**
	 * Stores items
	 * @var array
	 */
    protected $items = array();
    
	/**
	 * Creates Collection
	 * @param mixed(optional)
	 * @return void
	 */
    public function __construct() //getting all args and add to array
    {
        $arg_list = func_get_args();
           if($arg_list!=NULL)
           {
               foreach ($arg_list as $arg)
               {
                   $this->addItem($arg);
               }
           }
    }
	
    /**
	 * Add item to collection
	 * @param mixed $obj
	 * @param int|String $key(optional)
	 * @throws Exception
	 * @return void
	 */
    public function addItem($obj, $key = null) 
    {
        if ($key === null) 
        {
            $this->items[] = $obj;
        }
        else 
        {
            if (isset($this->items[$key])) 
            {
                throw new \Exception("Index $key jest w użyciu.");
            }
            else 
            {
                $this->items[$key] = $obj;
            }
        }
    }

	/**
	 * Delete item from collection
	 * @param int|String $key
	 * @throws Exception
	 * @return void
	 */
    public function deleteItem($key) 
    {
        if (isset($this->items[$key])) 
        {
            unset($this->items[$key]);
        }
        else 
        {
            throw new \Exception("Indeks $key nie istnieje.");
        }
    }

	/**
	 * Returns the item from the collection that is under the $key
	 * @param int|String $key
	 * @throws Exception
	 * @return mixed
	 */
    public function getItem($key) 
    {
        if (isset($this->items[$key])) 
        {
            return $this->items[$key];
        }
        else 
        {
            throw new \Exception("Indeks $key nie istnieje.");
        }
    }
    
	/**
	 * Returns collection length
	 * @return int
	 */
    public function length() 
    {
        return count($this->items);
    }
    
	/**
	 * Check if the $key exists
	 * @param int|String $key
	 * @return boolean
	 */
    public function keyExists($key) 
    {
        return isset($this->items[$key]);
    }
    
	/**
	 * Returns the first item of the collection
	 * @return mixed
	 */
    public function getFirstItem()
    {
        return reset($this->items);
    }
    
    /**
	 * Returns the last item of the collection
	 * @return mixed
	 */
    public function getLastItem()
    {
        return end($this->items);
    }
    
	/**
	 * Print aray to HTML
	 * @return void
	 */
    public function Show()
    {
        echo '<pre>';
        print_r($this->items);
        echo '</pre>';
    }
    
	/**
	 * Checks if the collection is empty
	 * @return boolean
	 */
    public function isEmpty()
    {
        return $this->length()==0;
    }
	
	/**
	 * Converts collection to array
	 * @return array
	 */
	public function toArray()
	{
		return $this->items;
	}
	
	public function __get($key) 
	{
		if (isset($this->items[$key])) 
        {
            return $this->items[$key];
        }
        else 
        {
            throw new Exception("Indeks $key nie istnieje.");
        }
	}
	
	public function __set($key, $obj) 
	{
        if (isset($this->items[$key])) 
        {
            throw new Exception("Index $key jest w użyciu.");
        }
        else 
        {
            $this->items[$key] = $obj;
        }
	}
}