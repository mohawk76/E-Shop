<?php

abstract class Model{

    protected $pdo;
 
    public function  __construct()
	{
        $dbConfig=require('../Config/dbConfig.php');
        $this->pdo=Database::getInstance();
        $this->pdo->connect(
		$dbConfig['type'],
		$dbConfig['host'],
		$dbConfig['user'], 
		$dbConfig['pass'],
		$dbConfig['name']);//connecting to MySQL database
    }
	
    public function loadModel($name, $path='../Models/') {
        $path=$path.$name.'.php';
        $name=$name.'Model';
        try {
            if(is_file($path)) {
                require $path;
                $ob=new $name();
            } else {
                throw new Exception('Can not open model '.$name.' in: '.$path);
            }
        }
        catch(Exception $e) {
            echo $e->getMessage().'<br />
                File: '.$e->getFile().'<br />
                Code line: '.$e->getLine().'<br />
                Trace: '.$e->getTraceAsString();
            exit;
        }
        return $ob;
    }

    public function select($from, $select='*', $where=NULL, $order=NULL, $limit=NULL) {
        $query='SELECT '.$select.' FROM '.$from;
        if($where!=NULL)
            $query=$query.' WHERE '.$where;
        if($order!=NULL)
            $query=$query.' ORDER BY '.$order;
        if($limit!=NULL)
            $query=$query.' LIMIT '.$limit;
 
        $select=$this->pdo->sendQuery($query);
        foreach ($select as $row) {
            $data[]=$row;
        }
 
        return $data;
    }
}