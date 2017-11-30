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

	public function addItems($array)
	{
		foreach ($array as $item)
		{
			$this->items[] = $item;
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
	 * Delete all items in array
	 */
	public function clear()
	{
		unset($this->items);
		$this->items = array();
	}

	/**
	 * Converts collection to array
	 * @return array
	 */
	public function toArray()
	{
		return $this->items;
	}
	
	/**
	 * @param mixed $key
	 * @return mixed
	 * @throws \Exception
	 */
	public function get($key) 
	{
		if (isset($this->items[$key])) 
        {
            return  $this->items[$key];
        }
        else 
        {
            throw new \Exception("Indeks $key nie istnieje.");
        }
	}
	
	/**
	 * @param mixed $key
	 * @return ref mixed
	 * @throws \Exception
	 */
	public function &getRef($key) 
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
	 * @param mixed $key
	 * @param mixed $obj
	 * @throws \Exception
	 */
	public function set($key, $obj) 
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
	
	/**
	 * Finds index with matching value
	 * @param mixed $value
	 * @return mixed Return index of matching element or false
	 */
	public function findValue($value)
	{
		return array_search($value, $this->items);
	}
	
	/**
	 * Finds index with matching value in 2 dimensional array
	 * @param mixed $value
	 * @param mixed $key
	 * @return mixed
	 */
	function findValueDim($searchValue, $searchKey)
	{
		foreach ($this->items as $key => $val)
		{
			if($val[$searchKey]==$searchValue)
			{
				return $key;
			}
		}
		
		return false;
	}
}