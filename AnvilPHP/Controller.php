<?php

namespace AnvilPHP;

abstract class Controller{
 
	/**
	 * Redirects to the specified address
	 * @param string $url specified address
	 * @return void
	 */
    public function redirect(string $url) 
	{
        header("location: ".$url);
    }
	
	/**
     * Generates URL
     * @param $name
     * @param null $data
     * @return bool|string
     */
 
    public function generateUrl($name, $data = null)
    {
        $router = new Router('http://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
        $collection = $router->getCollection();
        $route = $collection->get($name);
        if (isset($route)) {
            return $route->geneRateUrl($data);
        }
        return false;
    }
	
}
