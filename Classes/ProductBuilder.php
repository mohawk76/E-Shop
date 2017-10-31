<?php
require_once('Products.php');
require_once('AnvilPHP/Database.php');

class ErrorBuilderException extends Exception {}

class ProductBuilder {
	public $connect;

	public function __construct($connect) 
	{
		$this->connect = $connect;
	}
	
	public function createProduct(array $row)
	{
		if ($row["ID_Image"] != NULL) 
        {
            $imagePath = $this->connect->sendQuery((new Select('Path'))->From('images')->Where('id_image = '.$row['ID_Image']))[0]['Path'];
        }
        else
        {
            $imagePath = "";
        }
		
		$company = $this->connect->sendQuery((new Select('nazwa'))->From('producenci')->Where('id_producent = '.$row["id_producent"]))[0]['nazwa'];
		
		if(product::tryParse(array($row["Nazwa"], $row["Opis"], $company, $row["Cena"], $imagePath), $item))
		{
			return $item;
		}
		else 
		{
			throw new ErrorBuilderException("Error when try build Product object");
		}
	}
}
