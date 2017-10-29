<?php
    class connectFailedException extends Exception
    {
        const MSG = '<script>alert("Nie udało się połączyć z bazą danych.");</script>';
        public function __construct()
        {
            parent::__construct(self::MSG);
        }
    }
    
    /*
     * Class Database
     * Connecting with database and sending Queries
     */
    class Database
    {
        private $database;
        static private $instance = false;
        
        private function __construct() {}
        private function __clone() {}
        
        public function __destruct() {
            if(!$this->database->connect_errno)
            {
                $this->database->close();
            }
        }
        
        public static function getInstance(){
            if (!self::$instance) {
                self::$instance = new Database();
            }
            return self::$instance;
        }
        
        public function connect($dbAdress, $dbLogin, $dbPassword, $dbName)
        {
            $this->database = new mysqli($dbAdress, $dbLogin, $dbPassword, $dbName);
            
            if($this->database->connect_errno)
            {
                unset($this->database);
                throw new connectFailedException();
            } 
        }
        
        public function sendQuery($query)
        {
            return $this->database->query($query);
        }
        
        public function isConnected()
        {
            if($this->database)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    
    /*
     * Query Class
     * Generate Queries
     */
    abstract class Query{
        protected $columns = array();
        protected $tables= array();
        
        protected function tablesArray(array $array)
        {
            if(!empty($array))
            {
                foreach ($array as $item)
               {
                    if ($item != NULL) {
                    $this->tables[] = $item;
                }
            }
            }
        }
        
        protected function getColumns()
        {
            if (count($this->columns)!= 0) 
            {
                $result = $this->columns[0];
                foreach ($this->columns as $arg) 
                {
                    if($arg!=$this->columns[0])
                    {
                       $result .= ", ".$arg;
                    }
                }
                return $result;
            } 
            else 
            {
                return '*';
            }
        }
        
        private function getTables()
        {
             if (count($this->tables) != 0) 
            {
                $result = $this->tables[0];
                foreach ($this->tables as $arg) 
                {
                    if($arg!=$this->tables[0])
                    {
                       $result .= ", ".$arg;
                    }
                }
                return $result;
            } 
            else 
            {
                throw new InvalidArgumentException("Empty tables.");
            }
        }
        
        protected function getQuery()
        {
            return $this->getTables();
        }
    }
	
	/*
     * QueryWhere Class
     * Generate Queries that use where
     */
	abstract class QueryWhere extends Query
	{
		private $whereArgs= array();
		
		private function getWhereArgs()
        {
            if (count($this->whereArgs) != 0) 
            {
                $result = "WHERE ".$this->whereArgs[0];
                foreach ($this->whereArgs as $arg) 
                {
                    if($arg!=$this->whereArgs[0])
                    {
                       $result .= " AND ". $arg;
                    }
                }
                return $result;
            } 
            else 
            {
                return 'WHERE 1';
            }
        }
		
		public function Where()
        {
           $arg_list = func_get_args();
			if($arg_list!=NULL)
			{
				if(is_array($arg_list[0]))
				{
					$this->WhereArray($arg_list[0]);
				}
				 else 
				{
					$this->WhereArray($arg_list);
				}
			}
           return $this;
        }
        
        private function WhereArray(array $array)
        {
            if(!empty($array))
            {
                foreach ($array as $item)
               {
                    if ($item != NULL) 
					{
						$this->whereArgs[] = $item;
					}
				}	
            }
        }
		
		protected function getQuery()
		{
			return parent::getQuery().' '.$this->getWhereArgs();
		}
	}


    /*
     * Class Select
     * Generate Select queries
     */
    final class Select extends QueryWhere{
        private $orderArgs = array();
        private $limit = array();
        
        public function __construct()
        {
           $arg_list = func_get_args();
           if($arg_list!=NULL)
           {
               if (is_array($arg_list[0])) {
                    foreach ($arg_list[0] as $arg)
                    {
                        $this->columns[] = $arg;
                    }
               } 
               else 
               {
                    foreach ($arg_list as $arg) 
                    {
                        $this->columns[] = $arg;
                    }
               }
            }
        }
		

		public function From()
		{
			$arg_list = func_get_args();
			if($arg_list!=NULL)
			{
				if(is_array($arg_list[0]))
				{
					$this->tablesArray($arg_list[0]);
				}
				 else 
				{
					$this->tablesArray($arg_list);
				}
			}
			return $this;
		}

		public function OrderBy()
        {
           $arg_list = func_get_args();
			if($arg_list!=NULL)
			{
				if(is_array($arg_list[0]))
				{
					$this->OrderByArray($arg_list[0]);
				}
				 else 
				{
					$this->OrderByArray($arg_list);
				}
			}
			return $this;
        }
        
        private function OrderByArray(array $array)
        {
            if(!empty($array))
            {
               foreach ($array as $item)
               {
                   if ($item != NULL) {
                    $this->orderArgs[] = $item;
                }
				}
            }
        }
        
        private function getOrdeArgs()
        {
            if (count($this->orderArgs) != 0) 
            {
                $result = 'ORDER BY '.$this->orderArgs[0];
                foreach ($this->orderArgs as $arg) 
                {
                    if($arg!=$this->orderArgs[0])
                    {
                       $result .= ", ". $arg;
                    }
                }
                return $result;
            } 
            else 
            {
                return '';
            }
        }
        
        public function Limit($limit = 15, $offset=0)
        {
            $this->limit[]=$offset;
            $this->limit[]=$limit;
            
            return $this;
        }
        
        private function getLimit()
        {
            if (count($this->limit) != 0) 
            {
                return 'LIMIT ' . $this->limit[0] . ', ' . $this->limit[1];
            }
            else 
            {
                return "";
            }
        }

        protected function getQuery()
        {
            $result = 'SELECT '.$this->getColumns().' FROM '. parent::getQuery().' '. $this->getOrdeArgs().' '.$this->getLimit();
            return $result.';';
        }
        
        public function __toString() {
            return $this->getQuery();
        }
    }
	
    /*
     * Class Update
     * Generate Update queries
     */
    final class Update extends QueryWhere{
        public function __construct() {
			$arg_list = func_get_args();
			if($arg_list!=NULL)
			{
				if(is_array($arg_list[0]))
				{
					foreach ($arg_list[0] as $arg)
					{
						$this->tables[] = $arg;
					}
				}
				else 
				{
					foreach ($arg_list as $arg)
					{
						$this->tables[] = $arg;
					}
				}
			}
		}
		
		public function Set()
		{
			$arg_list = func_get_args();
			if($arg_list!=NULL)
			{
				if(is_array($arg_list[0]))
				{
					$this->SetArray($arg_list[0]);
				}
				 else 
				{
					$this->SetArray($arg_list);
				}
			}
			return $this;
		}
		
		private function SetArray($array)
		{
			if(!empty($array))
            {
				foreach ($array as $item)
				{
                   if ($item != NULL) 
					{
						$this->columns[] = $item;
					}	
				}
            }
		}	
		
		protected function getQuery()
		{
			$result = 'UPDATE ';
			$parentResults = explode(" ", parent::getQuery());
			
			$result .= $parentResults[0]." SET ".$this->getColumns()." ".$parentResults[1]." ";
			
			foreach ($parentResults as $i => $parentResult)
			{
				if ($i>2) 
				{
					$result .= " ".$parentResult;
				}
				else if($i==2)
				{
					$result .= $parentResult;
				}
			}
			
			return $result.';';	
		}
		
		public function __toString() {
			return $this->getQuery();
		}
    }
	
    /*
     * Class Insert
     * Generate Insert queries
     */
    final class Insert extends Query
	{
		private $values = array();
		
		public function __construct() 
		{
			$arg_list = func_get_args();
			if($arg_list!=NULL)
			{
				$this->tables[]=$arg_list[0];
				if(isset($arg_list[1]))
				{
					if(is_array($arg_list[1]))
					{
						foreach ($arg_list[1] as $arg)
						{
							$this->columns[] = $arg;
						}
					}
					else 
					{
						foreach ($arg_list as $arg)
						{
							if($arg!=$arg_list[0])
							{
								$this->columns[] = $arg;
							}
						}
					}
				}
			}
		}
		
		public function Values()
		{
			$arg_list = func_get_args();
			if($arg_list!=NULL)
			{
				if(is_array($arg_list[0]))
				{
					$this->ValuesArray($arg_list[0]);
				}
				 else 
				{
					$this->ValuesArray($arg_list);
				}
			}
			return $this;
		}
		
		private function ValuesArray($array)
		{
			if(!empty($array))
            {
				foreach ($array as $item)
				{
                   if ($item != NULL) 
					{
						$this->values[] = $item;
					}	
				}
            }
		}
		
		private function getValues()
		{
			if (count($this->values) != 0) 
            {
                $result = 'VALUES '.$this->values[0];
                foreach ($this->values as $arg) 
                {
                    if($arg!=$this->values[0])
                    {
                       $result .= ", ". $arg;
                    }
                }
                return $result;
            } 
            else 
            {
                return '';
            }
		}

		protected function getQuery() 
		{
			$result = 'INSERT INTO '.parent::getQuery().' ';
			$columns = $this->getColumns();
			if ($columns != '*') {
				$result .= '('.$columns . ') ';
			}
			$result	.= $this->getValues();
			return $result.';';
		}
		
		public function __toString() {
			return $this->getQuery();
		}
    }
    
	/*
     * Class Delete
     * Generate Delete queries
     */
    final class Delete extends QueryWhere
	{
		public function __construct() 
		{
			$arg_list = func_get_args();
			if($arg_list!=NULL)
			{
				$this->tables[]=$arg_list[0];
			}
		}
		
		protected function getQuery() {
			return 'DELETE FROM '.parent::getQuery();
		}
		
		public function __toString() {
			return $this->getQuery();
		}
    }
