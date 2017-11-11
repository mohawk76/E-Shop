<?php 

namespace AnvilPHP;

use AnvilPHP\Database\Database;

class SearchEngine{
    /**
	 * Connection with database
	 * @var Database
	 */	
    private $database;
	
	/**
	 * Keeps the name of the table in which the data is searched
	 * @var String
	 */
    private $tableName;
	
	/**
	 * Limit size of data from database
	 * @var int
	 */
    private $limit;
			 
	/**
	 * Creates SearchEngine
	 * @param Database $database
	 * @param String $tableName
	 * @param int $limit
	 * @return void
	 */
    public function __construct(Database $database, String $tableName, int $limit = 12) {
        $this->database = $database;
        $this->tableName = $tableName;
        $this->limit = $limit;
    }
    
	/**
	 * Sets limit size of data
	 * @param int $limit
	 */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;
    }
    
	/**
	 * Returns limit size of data
	 * @return int
	 */
    public function getLimit()
    {
        return $this->limit;
    }
	
    /**
	 * Searches the database according to the criteria and returns the corresponding records
	 * @param array of strings $select_args
	 * @param array of strings $where_args
	 * @param array of strings $order_args
	 * @param int $dbOffset from which element in the database to start searching
	 * @return array
	 */
    public function search($select_args=array(), $where_args=array(), $order_args=array(), $dbOffset = 0)
    {
        $query = (new \AnvilPHP\Database\Select($select_args))->From($this->tableName)->Where($where_args)->OrderBy($order_args)->Limit($this->limit, $dbOffset);//Generate query
		
        //echo "$query<br>";
        $result = $this->database->sendQuery($query);//Send query and return array
		return $result;
    }   
}