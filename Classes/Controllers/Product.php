<?php

namespace Shop\Controllers;

class Product extends \AnvilPHP\Controller
{
	public function addToCart()
	{
		$get = \AnvilPHP\Get::getInstance();
		
		if($get->get('id'))
		{
            $id = $get->get('id');
        } 
		else 
		{
            die();
        }
		
		if($get->get('quantity'))
		{
            $quantity = $get->get('quantity');
        } 
		else 
		{
            $quantity = 1;
        }
		
		$model = new \Shop\Models\Product();
		$view = new \Shop\Views\Product();
		
		if(!$model->productExist($id))
		{
			$view->renderHTML("Produkt nie istnieje");
			die();
		}
		
		$model->addToCart($id, $quantity);
		
		$view->renderHTML("Dodano do koszyka!");
	}
	
	public function clearCart()
	{
		$model = new \Shop\Models\Product();
		$model->clearCart();
	}
	
	public function deleteFromCart()
	{
		$get = \AnvilPHP\Get::getInstance();
		
		$id = $get->get('productID');
		
		$model = new \Shop\Models\Product();
		
		$view = new \Shop\Views\Product();
		
		if(!$model->deleteFromCart($id))
		{
			$view->renderHTML('Produktu nie ma w koszyku.');
		}
		else 
		{
			
			$view->renderHTML("Produkt został usunięty z koszyka.");
		}
	}
	
	public function showCart()
	{
		$session = \AnvilPHP\Session::getInstance();
		$session->ShoppingCart->Show();
	}
	
	public function loadProducts()
	{
		$get = \AnvilPHP\Get::getInstance();
		$model = new \Shop\Models\Product();
		$view = new \Shop\Views\Product();

		if($get->exist('page'))
		{
            $page=$get->get('page');
        } 
		else 
		{
            $page=1;
        }
		
		$getValues = explode('?', $_SERVER['REQUEST_URI']);//Split REQUEST_URI and get $_GET parameters
		
		$products['url'] = '?page='.$page; //set Get parametr page
		
		if(isset($getValues[1]))//Check if there are any GET arguments
		{
			$getUrl = explode('&', $getValues[1]);//get each parameters
			
			$getValues = '?'.$getValues[1]; //save GET arguments in $getValues
			
			if(!empty($get->get('searched')))//If the parameter is specified, it adds to the generated url
			{
				$products['url'] .= "&".$getUrl[0];
			}
			
			if(!empty($get->get('category')))//If the parameter is specified, it adds to the generated url
			{
				if(empty($getUrl[1]))
				{
					$products['url'] .= "&".$getUrl[0];
				}
				else
				{
					$products['url'] .= "&".$getUrl[1];
				}
			}
		}
		else
		{
			$getValues = "";//if there aren't any arguments set empty string
		}
		
		$pagination = new \AnvilPHP\Pagination($this->generateUrl('loadProductsPage', array('page' => '{page}')).$getValues);//create pagination and generate url for links
		$pagination->setTotalItems($model->getTotalNumberProducts());
		$pagination->setPage($page);
		$pagination->setItemsPerPage(4);
		
		$products['products'] = $view->loadProducts($model->loadProducts(
			$pagination->getItemsPerPage(),
			($page-1)*$pagination->getItemsPerPage()), "Templates/productTemplate.html");//loads the HTML code of the products
		
		$products['pagination'] = strval($pagination);//loads the HTML code of the pagination
				
		$view->renderJSON($products);//render json on page
	}
	
	public function deleteProductToDB()
	{
		
	}
	
	public function addProductToDB()
	{
		
	}
}
