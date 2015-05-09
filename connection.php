<?php 

/**
 * simple class to handle db connection 
 */

	class connection{
		public $db;
		public $HOST = 'localhost';
		public $DB_NAME = 'aec';
		public $USER_NAME = 'root';
		public $PASSWORD = 'password';
		
		function __construct(){
			try{
				$db = new pdo('mysql:host='.$this->HOST.';dbname='.$this->DB_NAME,$this->USER_NAME,$this->PASSWORD);
				$this->db = $db;
			}catch(PDOException $e){
				echo $e->getMessage();
			}

		}	
	}

 ?>