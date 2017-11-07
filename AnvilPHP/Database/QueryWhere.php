<?php

namespace AnvilPHP\Database;

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