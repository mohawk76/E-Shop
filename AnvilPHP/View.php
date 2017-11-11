<?php

namespace AnvilPHP;

abstract class View
{
	
	private $template;

	public function generateUrl($name, $data=null) 
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
	
	public function setTemplate(Template $template)
	{
		$this->template = $template;
	}
	
	public function getTemplate()
	{
		return $this->template;
	}

	public function renderTemplateHTML() 
	{
        print($this->template);
    }
	
	public function renderHTML($html)
	{
		print($html);
	}

	public function renderJSON($data)
	{
        header('Content-Type: application/json');
		print(json_encode($data));
        exit;
    }
	
	public function __get($name) 
	{
		return $this->template->$name;
	}
	
	public function __set($name, $value)
	{
		$this->template->$name = $value;
	}
}