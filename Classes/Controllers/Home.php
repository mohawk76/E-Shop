<?php

namespace Shop\Controllers;

class Home extends \AnvilPHP\Controller
{
	public function index()
    {
		$get = \AnvilPHP\Get::getInstance();
		if($get->page)
		{
            $page=$get->page;
        } 
		else 
		{
            $page=1;
        }
        $model = new \Shop\Models\Home();
		
        $categories = $model->getCategories();
		$pagination = new \AnvilPHP\Pagination($this->generateUrl('indexPage', array('page' => '{page}')));
		$pagination->setTotalItems($model->getTotalNumberProducts());
		$pagination->setPage($page);
		$pagination->setItemsPerPage(4);
		
        $view = new \Shop\Views\Home();
		
        $template = new \AnvilPHP\Template('Templates/indexTemplate.html');
		$view->setTemplate($template);	
		
		$view->categories = $categories;
		$view->searchLast = \AnvilPHP\Get::getInstance()->filteredInput('searched');
		$view->products = $model->loadProducts($pagination->getItemsPerPage(), (($page-1)*$pagination->getItemsPerPage()));
		$view->pagination = $pagination;
		
        $view->renderTemplateHTML();
    }

}
