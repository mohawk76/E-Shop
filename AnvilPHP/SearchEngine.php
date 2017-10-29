<?php 
require_once 'Database.php';
class SearchEngine{
    
    private $database;
    private $tableName;
    private $limit;//limit size of data from database
    private $result;
			 
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
        $query = (new Select($select_args))->From($this->tableName)->Where($where_args)->OrderBy($order_args)->Limit($this->limit, $dbOffset);

        //echo "$query<br>";
        $this->result = $this->database->sendQuery($query);
		return $this;
    } 
	
	private function getSimilarity(string $arg, string $pattern) 
	{
		return (1.0/(1.0 + levenshtein($arg, $pattern)));
	}
	
	private function sortBySimilarity($a, $b)
	{
		if($a['_SIMILARITY']==$b['_SIMILARITY'])
		{
			return 0;
		}
		
		return ($a['_SIMILARITY']<$b['_SIMILARITY']) ? -1 : 1;
	}

	public function getResult($columnName=NULL , $pattern=NULL)
	{	
		$result = array();
		while ($row = $this->result->fetch_assoc())
		{
			if(($columnName!=NULL) && ($pattern!=NULL))
			{
				$row['_SIMILARITY'] = $this->getSimilarity($row[$columnName], $pattern);
			}
			$result[] = $row;
		}
		
		if (($columnName != NULL) && ($pattern != NULL)) {
			uasort($result, array($this, 'sortBySimilarity'));
		}

		return $result;
	}
    
}