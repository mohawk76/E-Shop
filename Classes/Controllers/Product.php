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
	
	public function changeQuantity()
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
            die();
        }
		
		$model = new \Shop\Models\Product();
		$model->changeQuantity($id, $quantity);
	}
	
	public function clearCart()
	{
		$model = new \Shop\Models\Product();
		$model->clearCart();
	}
	
	public function deleteFromCart()
	{
		$get = \AnvilPHP\Get::getInstance();
		
		$id = $get->get('id');
		
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
	
	public function loadProductsFromCart()
	{
		$model = new \Shop\Models\Product();
		$view = new \Shop\Views\Product();
		
		$products = $model->getProductsFromCart();
		
		$result['products'] = $view->loadProducts(
				$products,
				$this->generateUrl('deleteFromCart', array('id' => '{id}')),
				"Templates/productCart.html");
		
		$result['sum'] = number_format($products->getSumPrice(), 2, ',', ' ');
		
		$view->renderJSON($result);
	}


	public function showCart()
	{
		$model = new \Shop\Models\Product();
		$view = new \Shop\Views\Product();
		
		$template = new \AnvilPHP\Template("Templates/basket.html");
		
		$view->setTemplate($template);
		
		$view->products = $this->generateUrl('loadProductsCart');
		$view->home = HTTP_SERVER;
		
		$view->renderTemplateHTML();
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
			$getsUrl = explode('&', $getValues[1]);//get each parameters
			
			$getValues = '?'.$getValues[1]; //save GET arguments in $getValues
			
			foreach ($getsUrl as $getUrl)
			{
				if(!empty($get->get(substr($getUrl, 0, strpos($getUrl, '=')))))
				{
					$products['url'] .= "&".$getUrl;
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
		$pagination->setItemsPerPage(12);
		
		$products['products'] = $view->loadProducts(
			$model->getProducts(
				$pagination->getItemsPerPage(),
				($page-1)*$pagination->getItemsPerPage()),
			$this->generateUrl('addToCart', array('id' => '{id}')),
			"Templates/productTemplate.html");//loads the HTML code of the products
		
		$products['pagination'] = strval($pagination);//loads the HTML code of the pagination
				
		$view->renderJSON($products);//render json on page
	}
	
	public function deleteProductFromDB()
	{
		$get = \AnvilPHP\Get::getInstance();
		
		$id = $get->get("id");
		
		if($id!=NULL)
		{
			$model = new \Shop\Models\Product();
			$view = new \Shop\Views\Product();
			
			if(!$model->productExist($id))
			{
				$view->renderHTML("Produkt nie istnieje");
				die();
			}
			
			$success = $model->deleteProductFromDB($id);
			
			if($success)
			{
				$view->renderHTML("Produkt został usunięty z bazy.");
			}
			else 
			{
				$view->renderHTML("Nie udało się usunąć produktu.");
			}
		}		
	}

	public function addProductToDB()
	{
		
	}
}
