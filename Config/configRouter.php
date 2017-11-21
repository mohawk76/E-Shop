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

$collection->addItem(new AnvilPHP\Route(
    'actionLogin',
    array(
        'file' => DIR_CONTROLLER.'UserService.php',
        'method' => 'actionLogin',
        'class' => '\Shop\Controllers\UserService'
    )
), 'actionLogin');

$collection->addItem(new AnvilPHP\Route(
    'actionRegister',
    array(
        'file' => DIR_CONTROLLER.'UserService.php',
        'method' => 'actionRegister',
        'class' => '\Shop\Controllers\UserService'
    )
), 'actionRegister');

$collection->addItem(new AnvilPHP\Route(
    'deleteProduct',
    array(
        'file' => DIR_CONTROLLER.'Product.php',
        'method' => 'deleteProductFromDB',
        'class' => '\Shop\Controllers\Product'
    )
), 'deleteProduct');

$collection->addItem(new AnvilPHP\Route(
    'loadProductsCart',
    array(
        'file' => DIR_CONTROLLER.'Product.php',
        'method' => 'loadProductsFromCart',
        'class' => '\Shop\Controllers\Product'
    )
), 'loadProductsCart');

$collection->addItem(new AnvilPHP\Route(
    'changeQuantity/<id>?',
    array(
        'file' => DIR_CONTROLLER.'Product.php',
        'method' => 'changeQuantity',
        'class' => '\Shop\Controllers\Product'
    ),
    array(
        'id' => '\d+'
    )
), 'changeQuantity');

$collection->addItem(new AnvilPHP\Route(
    'logout',
    array(
        'file' => DIR_CONTROLLER.'UserService.php',
        'method' => 'logout',
        'class' => '\Shop\Controllers\UserService'
    )
), 'logout');

$router = new AnvilPHP\Router($_SERVER['REQUEST_URI'], $collection);