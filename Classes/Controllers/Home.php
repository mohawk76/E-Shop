<?php

namespace Shop\Controllers;

class Home extends \AnvilPHP\Controller
{
	public function index()
    {
		$get = \AnvilPHP\Get::getInstance();
		$session = \AnvilPHP\Session::getInstance();
		
        $model = new \Shop\Models\Home();
		
		$menuCategories = new \AnvilPHP\HTMLGenerators\div();
		$menuCategories->elements->addItems($model->getLinkPlatform($this->generateUrl('loadProducts')));
		$menuCategories->id = "platform"; 
		$menuCategories->class = "podMenu";
				
        $searchCategories = $model->getSpanCategories();
		
        $view = new \Shop\Views\Home();
		
		$subMenuTemplate = new \AnvilPHP\Template('Templates/SubMenu.html');
		$subMenuTemplate->categories = $menuCategories ;

		
        $template = new \AnvilPHP\Template('Templates/index.html');
		$view->setTemplate($template);	
		
		$UserUi;
		if(\Shop\Models\UserService::isLogged())
		{
			$UserUi = new \AnvilPHP\Template("Templates/userButton.html");
			$UserUi->href = "logout";
			$UserUi->classButton = "login";
			$UserUi->text = "Wyloguj";
		}
		else
		{
			$LoginButton = new \AnvilPHP\Template("Templates/userButton.html");
			$LoginButton->href = "login";
			$LoginButton->classButton = "login";
			$LoginButton->text = "Zaloguj";
			
			$RegisterButton = new \AnvilPHP\Template("Templates/userButton.html");
			$RegisterButton->href = "register";
			$RegisterButton->classButton = "register";
			$RegisterButton->text = "Rejestracja";
			
			$UserUi = \AnvilPHP\Template::merge(array($LoginButton, $RegisterButton), "");
		}
		
		$view->ui = $UserUi;
		$view->categories = $searchCategories;
		$view->searchLast = $get->filteredInput('searched');
		$view->loadProductsURL = $this->generateUrl('loadProducts');
		$view->submenu = $subMenuTemplate;
		
		$view->shoppingCart = $this->generateUrl('showCart');
				
        $view->renderTemplateHTML();
    }
}
