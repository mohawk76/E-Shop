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
		if(\Shop\Product\product::tryParse(array($row["GAME_ID"], $row["Name"], $row["Description"], $row["Price"], $row["ImagePath"]), $item))
		{
			return $item;
		}
		else 
		{
			throw new ErrorBuilderException("Error when try build Product object");
		}
	}
}
