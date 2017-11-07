<?php

namespace AnvilPHP\Database;

	/*
     * Class Insert
     * Generate Insert queries
     */
    class Insert extends Query
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