<?php

namespace AnvilPHP\Database;

	/*
     * Class Delete
     * Generate Delete queries
     */
    class Delete extends QueryWhere
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