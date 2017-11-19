<?php

namespace Shop\Controllers;

class Home extends \AnvilPHP\Controller
{
	public function index()
    {
		$get = \AnvilPHP\Get::getInstance();
		$session = \AnvilPHP\Session::getInstance();
		
        $model = new \Shop\Models\Home();
		
		$menuCategories = $model->getLinkCategories($this->generateUrl('loadProducts'));
        $searchCategories = $model->getSpanCategories();
		
        $view = new \Shop\Views\Home();
		
		$subMenuTemplate = new \AnvilPHP\Template('Templates/Categories.html');
		$subMenuTemplate->categories = $menuCategories ;

		
        $template = new \AnvilPHP\Template('Templates/index.html');
		$view->setTemplate($template);	
		
		$view->categories = $searchCategories;
		$view->searchLast = $get->filteredInput('searched');
		$view->loadProductsURL = $this->generateUrl('loadProducts');
		$view->submenu = $subMenuTemplate;
		
		$view->shoppingCart = $this->generateUrl('showCart');
				
        $view->renderTemplateHTML();
    }
}
