<?php
class Collection 
{
    protected $items = array();
    
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
    
    public function addItem($obj, int $key = null) 
        {
        if ($key === null) 
        {
            $this->items[] = $obj;
        }
        else 
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


    public function deleteItem(int $key) 
    {
        if (isset($this->items[$key])) 
        {
            unset($this->items[$key]);
        }
        else 
        {
            throw new Exception("Indeks $key nie istnieje.");
        }
    }

    public function getItem(int $key) 
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
    
    public function length() 
    {
        return count($this->items);
    }
    
    public function keyExists($key) 
    {
        return isset($this->items[$key]);
    }
    
    public function getFirstItem()
    {
        return $this->items[0];
    }
    
    
    public function getLastItem()
    {
        return end($this->items);
    }
    
    public function Show()
    {
        echo '<pre>';
        print_r($this->items);
        echo '</pre>';
    }
    
    public function isEmpty()
    {
        return $this->length()==0;
    }
	
	public function toArray()
	{
		return $this->items;
	}
}