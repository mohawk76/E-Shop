<?php

namespace Shop\Controllers;

class Home extends \AnvilPHP\Controller
{
	public function index()
    {
		$get = \AnvilPHP\Get::getInstance();
		$session = \AnvilPHP\Session::getInstance();
		
        $model = new \Shop\Models\Home();
		
        $categories = $model->getCategories();
		
        $view = new \Shop\Views\Home();
		
        $template = new \AnvilPHP\Template('Templates/indexTemplate.html');
		$view->setTemplate($template);	
		
		$view->categories = $categories;
		$view->searchLast = \AnvilPHP\Get::getInstance()->filteredInput('searched');
		$view->loadProductsURL = $this->generateUrl('loadProducts');
		
		$view->shoppingCart = $this->generateUrl('showCart');
				
        $view->renderTemplateHTML();
    }
}
