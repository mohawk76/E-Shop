<?php

namespace AnvilPHP;

abstract class Model{

	/**
	 * Holds connection with database
	 * @var Database
	 */
    protected $database;
 
	/**
     * Connects with the database.
     * @return void
     */
    public function  __construct()
	{
        $dbConfig=require(DIR_CONFIG.'dbConfig.php');//Get login information from the configuration file
        $this->database= Database\Database::getInstance();//Get reference to database
        $this->database->connect(
		$dbConfig['type'],
		$dbConfig['host'],
		$dbConfig['user'], 
		$dbConfig['pass'],
		$dbConfig['name']);//Connect with database
    }
}