<?php
require_once('Config/config.php');
require_once(DIR_VENDOR.'autoload.php');
require_once('Config/configRouter.php');

$session = \AnvilPHP\Session::getInstance();

if(!isset($session->ShoppingCart))
{
	$session->ShoppingCart = new \AnvilPHP\Collection();
}

$router = new AnvilPHP\Router('http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);
$router->run();

$file=$router->getFile();

$classController=$router->getClass();

$method=$router->getMethod();

if(empty($file))
{
	http_response_code(404);
	print('<center><h1>404 Not Found</h1></center>');
	die();
}

$obj = new $classController();
$obj->$method();
