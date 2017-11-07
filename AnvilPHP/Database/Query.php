<?php

namespace AnvilPHP\Database;

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
