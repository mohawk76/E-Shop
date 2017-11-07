<?php

namespace AnvilPHP\Database;


    /*
     * Class Update
     * Generate Update queries
     */
    class Update extends QueryWhere{
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