<?php

namespace AnvilPHP\Database;

    /*
     * Class Select
     * Generate Select queries
     */
    class Select extends QueryWhere{
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
	