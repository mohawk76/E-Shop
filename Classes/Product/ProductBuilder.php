<?php

namespace Shop\Product;
use AnvilPHP\Database\Database;

/**
 * Building products
 */
class ProductBuilder {
	/**
	 *
	 * @var Database
	 */
	public $connect;

	/**
	 * 
	 * @param Database $connect
	 */
	public function __construct(Database $connect) 
	{
		$this->connect = $connect;
	}
	
	/**
	 * 
	 * @param array $row
	 * @return product
	 * @throws ErrorBuilderException
	 */
	public function createProduct(array $row)
	{
		if ($row["ID_Image"] != NULL) 
        {
            $imagePath = $this->connect->sendQuery((new \AnvilPHP\Database\Select('Path'))->From('images')->Where('id_image = '.$row['ID_Image']))[0]['Path'];
        }
        else
        {
            $imagePath = "";
        }
		
		$company = $this->connect->sendQuery((new \AnvilPHP\Database\Select('nazwa'))->From('producenci')->Where('id_producent = '.$row["id_producent"]))[0]['nazwa'];
		
		if(\Shop\Product\product::tryParse(array($row["Nazwa"], $row["Opis"], $company, $row["Cena"], $imagePath), $item))
		{
			return $item;
		}
		else 
		{
			throw new ErrorBuilderException("Error when try build Product object");
		}
	}
}
