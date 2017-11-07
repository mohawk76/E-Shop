<?php 

namespace AnvilPHP;

use AnvilPHP\Database\Database;

class SearchEngine{
    
    private $database;
    private $tableName;
    private $limit;//limit size of data from database
			 
    public function __construct(Database $database, String $tableName, int $limit = 15) {
        $this->database = $database;
        $this->tableName = $tableName;
        $this->limit = $limit;
    }
    
    public function setLimit(int $limit)
    {
        $this->limit = $limit;
    }
    
    public function getLimit()
    {
        return $this->limit;
    }
	
    //generate SQL Query and return result
    public function search($select_args=array(), $where_args=array(), $order_args=array(), $dbOffset = 0)
    {
        $query = (new \AnvilPHP\Database\Select($select_args))->From($this->tableName)->Where($where_args)->OrderBy($order_args)->Limit($this->limit, $dbOffset);

        //echo "$query<br>";
        $result = $this->database->sendQuery($query);
		return $result;
    }   
}