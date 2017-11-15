<?php

namespace AnvilPHP;
/**
 * @abstract
 */
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
     * @param string $data
     * @return bool|string
     */
    public function generateUrl($name, $data = null)
    {
        $router = new Router('http://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);//Creating router
        $collection = $router->getCollection();//Get route collection
		
		try
		{
			$route = $collection->getItem($name);//Get route
		}
		catch(Exception $ex)
		{	
			http_response_code(404);
			print('<h1>404 Not Found</h1>');
			die();
		}
		
		return $route->generateUrl($data);
	}
	
}
