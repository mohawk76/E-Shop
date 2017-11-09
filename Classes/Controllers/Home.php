<?php

namespace Shop\Controllers;

class Home extends \AnvilPHP\Controller
{
	public function index()
    {
        $model = new \Shop\Models\Home();
		
        $categories = $model->getCategories();
		
        $view = new \Shop\Views\Home();
		
        $template = new \AnvilPHP\Template('Templates/indexTemplate.html');
		
		$template->categories = $categories;
		$template->searchLast = \AnvilPHP\Get::getInstance()->filteredInput('searched');
		
        $view->renderHTML($template);
    }
	
	public function Products()
	{
		$model = new \Shop\Models\Home();
		$products = $model->loadProducts();
		
		$view = new \Shop\Views\Home();
		
		$view->renderHTML($products);
	}

}
