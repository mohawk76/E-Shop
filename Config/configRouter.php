<?php

$collection = new \AnvilPHP\RouteCollection();

$collection->addItem(new AnvilPHP\Route(
    HTTP_SERVER,
    array(
        'file' => DIR_CONTROLLER.'Home.php',
        'method' => 'index',
        'class' => '\Shop\Controllers\Home'
    )
), 'index');

$collection->addItem(new AnvilPHP\Route(
    HTTP_SERVER.'loadProducts',
    array(
        'file' => DIR_CONTROLLER.'Home.php',
        'method' => 'Products',
        'class' => '\Shop\Controllers\Home'
    )
), 'loadProducts');
 
$router = new AnvilPHP\Router($_SERVER['REQUEST_URI'], $collection);
