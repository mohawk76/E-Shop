<?php

$collection = new \AnvilPHP\RouteCollection();

$collection->addItem(new AnvilPHP\Route(
    '',
    array(
        'file' => DIR_CONTROLLER.'Home.php',
        'method' => 'index',
        'class' => '\Shop\Controllers\Home'
    )
), 'index');

$collection->addItem(new AnvilPHP\Route(
    'loadProducts/<page>?',
    array(
        'file' => DIR_CONTROLLER.'Product.php',
        'method' => 'loadProducts',
        'class' => '\Shop\Controllers\Product'
    ),
	array(
        'page' => '\d+'
    ),
    array(
        'page' => 1
	)
), 'loadProductsPage');

$collection->addItem(new AnvilPHP\Route(
    'loadProducts',
    array(
        'file' => DIR_CONTROLLER.'Product.php',
        'method' => 'loadProducts',
        'class' => '\Shop\Controllers\Product'
    )
), 'loadProducts');

$collection->addItem(new AnvilPHP\Route(
    'addItemToCart/<id>?',
    array(
        'file' => DIR_CONTROLLER.'Product.php',
        'method' => 'addToCart',
        'class' => '\Shop\Controllers\Product'
    ),
    array(
        'id' => '\d+'
    )
), 'addToCart');

$collection->addItem(new AnvilPHP\Route(
    'clearCart',
    array(
        'file' => DIR_CONTROLLER.'Product.php',
        'method' => 'clearCart',
        'class' => '\Shop\Controllers\Product'
    )
), 'clearCart');

$collection->addItem(new AnvilPHP\Route(
    'deleteFromCart/<id>?',
    array(
        'file' => DIR_CONTROLLER.'Product.php',
        'method' => 'deleteFromCart',
        'class' => '\Shop\Controllers\Product'
    ),
    array(
        'id' => '\d+'
    )
), 'deleteFromCart');

$collection->addItem(new AnvilPHP\Route(
    'showCart',
    array(
        'file' => DIR_CONTROLLER.'Product.php',
        'method' => 'showCart',
        'class' => '\Shop\Controllers\Product'
    )
), 'showCart');

$collection->addItem(new AnvilPHP\Route(
    'login',
    array(
        'file' => DIR_CONTROLLER.'UserService.php',
        'method' => 'login',
        'class' => '\Shop\Controllers\UserService'
    )
), 'login');

$collection->addItem(new AnvilPHP\Route(
    'register',
    array(
        'file' => DIR_CONTROLLER.'UserService.php',
        'method' => 'register',
        'class' => '\Shop\Controllers\UserService'
    )
), 'register');

$router = new AnvilPHP\Router($_SERVER['REQUEST_URI'], $collection);