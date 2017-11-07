<?php
    
namespace AnvilPHP\Database;

use \PDO;

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
        
        public function __destruct() 
		{
			unset($this->database);
        }
        
        public static function getInstance(){
            if (!self::$instance) {
                self::$instance = new Database();
            }
            return self::$instance;
        }
        
        public function connect($dbType,$dbAdress, $dbLogin, $dbPassword, $dbName)
        {
			$dsn = "$dbType:dbname=$dbName;host=$dbAdress";
            try 
			{
				$this->database = new PDO($dsn, $dbLogin, $dbPassword);
				$this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			} 
			catch (PDOException $e) 
			{
				echo 'Connection failed: ' . $e->getMessage();
				unset($this->database);
			}
        }
        
        public function sendQuery($query)
        {
			if(strpos(strtolower($query), 'select')!==False)
			{
				$stmt = $this->database->query($query);
				$result = $stmt->fetchAll();
				$stmt->closeCursor();
				unset($stmt);
				return $result;
			}
			else 
			{
				$stmt = $this->database->exec($query);
				return $stmt;
			}
            
        }
        
        public function isConnected()
        {
            if(isset($this->database))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }