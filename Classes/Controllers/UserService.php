<?php

namespace Shop\Controllers;

/**
 * Provides access to login and registration
 */
class UserService extends \AnvilPHP\Controller
{
	/**
	 * User authorization
	 * @param string $login
	 * @param string $password
	 * @return void
	 */
	
	public function login()
	{		
		$view = new \Shop\Views\UserService();
		$model = new \Shop\Models\UserService();
		
		if($model->isLogged())
		{
			header("Location: ".HTTP_SERVER);
			die();
		}
		
		$template = new \AnvilPHP\Template("Templates/login.html");
		
		$view->setTemplate($template);
		$view->renderTemplateHTML();
	}
			
    public function actionLogin()
    {	
		$model = new \Shop\Models\UserService();
		$view = new \Shop\Views\UserService();
		
		if(!$model->isLogged())
		{
			$post = \AnvilPHP\Post::getInstance();

			$login = $post->filteredInput("login");
			$password = $post->get('password');

			$user = $model->getUser($login);

			if (count($user) > 0) 
			{
				if(/*password_hash($password, PASSWORD_BCRYPT)*/$password == $user[0]['Password']) 
				{
					\AnvilPHP\Session::getInstance()->user = new \AnvilPHP\User($user[0]['ID'], $user[0]['Login']);
					$view->renderHTML("Zalagowano!");
				}
				else 
				{	
					$view->renderHTML("Złe hasło!");
				}
			}
			else 
			{
				$view->renderHTML("Użytkownik nie istnieje!");
			}
		}
		else
		{
			$view->renderHTML("Użytkownik jest już zalogowany!");
		}
    }
	
	/**
	 * Writes the user to the database
	 * @param string $login
	 * @param string $password
	 * @param string $email
	 * @param string $name
	 * @param string $surname
	 * @param string $postcode
	 * @param string $city
	 * @param string $address
	 * @return void
	 */
	public function actionRegister()
	{
		$model = new \Shop\Models\UserService();
		$view = new \Shop\Views\UserService();
		$post = \AnvilPHP\Post::getInstance();
		
		if($model->isLogged())
		{
			header("Location: ".HTTP_SERVER);
			die();
		}
		
		$userData = $post->get();
		if(count($userData)==8)
		{
			if(strlen($userData['login']) > 32)
			{
				echo 'Za długi login';
				die();
			}
			else if(strlen($userData['login']) < 6)
			{
				echo 'Za krótki login';
				die();
			}

			if(strlen($userData['password']) < 6)
			{
				echo 'Twoje hasło jest za krótkie"';
				die();
			}

			if(filter_input($userData['email'], FILTER_VALIDATE_EMAIL))
			{
				echo 'Zły format e-mail\'a"';
				die();
			}

			$password = password_hash($password, PASSWORD_BCRYPT);

			if($model->addUser($userData)>0)
			{
				echo 'Pomyślnie zarejestrowano';
			}
			else
			{
				echo 'Nie udało się zarejestrować';
			}
		}
	}
	
	public function deleteUser()
	{
		$model = new \Shop\Models\UserService();
		$view = new \Shop\Views\UserService();		
		
		if($model->deleteUser($id))
		{
			$view->renderHTML("Użytkownik został pomyślnie usunięty");
		}
		else 
		{
			$view->renderHTML("Nie udało się usunąć użytkownika");
		}
	}
}
