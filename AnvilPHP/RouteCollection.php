<?php

namespace AnvilPHP;

/**
 * Containing Routes
 */
class RouteCollection extends Collection {
	/**
	 * 
	 * @param Route $obj
	 * @param String|Int $key
	 * @throws InvalidArgumentException
	 * @return void
	 */
	public function addItem($obj, $key=NULL)
    {
        if (!($obj instanceof Route))
        {
            throw new \InvalidArgumentException(__METHOD__.' expects instance of Route, you passed '.get_class($obj));
        }
        parent::addItem($obj, $key);
    }
}