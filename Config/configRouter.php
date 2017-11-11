<?php

$collection = new \AnvilPHP\RouteCollection();

$collection->addItem(new AnvilPHP\Route(
    HTTP_SERVER,
    array(
        'file' => DIR_CONTROLLER.'Home.php',
        'method' => 'index',
        'class' => '\Shop\Controllers\Home'
    ),
    array(
        'page' => '\d+'
    ),
    array(
        'page' => 1
	)
), 'index');

$collection->addItem(new AnvilPHP\Route(
    HTTP_SERVER.'<page>?',
    array(
        'file' => DIR_CONTROLLER.'Home.php',
        'method' => 'index',
        'class' => '\Shop\Controllers\Home'
    ),
    array(
        'page' => '\d+'
    ),
    array(
        'page' => 1
	)
), 'indexPage');
 
$router = new AnvilPHP\Router($_SERVER['REQUEST_URI'], $collection);
