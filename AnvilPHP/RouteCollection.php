<?php

namespace AnvilPHP;

/**
 * Containing Routes
 */
class RouteCollecion extends Collection {
	/**
	 * 
	 * @param Route $obj
	 * @param String|Int $key
	 * @throws InvalidArgumentException
	 */
	public function addItem($obj, $key)
    {
        if (!($obj instanceof Route))
        {
            throw new InvalidArgumentException(__METHOD__.' expects instance of Route, you passed '.get_class($obj));
        }
        parent::addItem($obj, $key);
    }
}